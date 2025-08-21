<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $brands = Brand::orderBy('name')->get(['id', 'name']);

        $businessId = $this->getBusinessId();

        $products = Product::forUserBusiness()
            ->select('products.*')
            ->addSelect([
                'latest_purchase_price' => DB::table('purchase_details')
                    ->select('purchase_price')
                    ->whereColumn('product_id', 'products.id')
                    ->where('business_id', $businessId)
                    ->orderBy('id', 'desc')
                    ->limit(1),

                'latest_selling_price' => DB::table('purchase_details')
                    ->select('selling_price')
                    ->whereColumn('product_id', 'products.id')
                    ->where('business_id', $businessId)
                    ->orderBy('id', 'desc')
                    ->limit(1),

                'total_unsell' => DB::table('purchase_details')
                    ->selectRaw('COALESCE(SUM(number_of_unsell), 0)')
                    ->whereColumn('product_id', 'products.id')
                    ->where('business_id', $businessId)
            ])
            ->with(['category:id,name', 'brand:id,name', 'unit:id,name'])
            ->when($request->s, function ($query) use ($request) {
                $query->where('name', 'LIKE', '%' . $request->s . '%')
                    ->orWhere('sku', 'LIKE', '%' . $request->s . '%');
            })
            ->when($request->category_id, function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            })
            ->when($request->brand_id, function ($query) use ($request) {
                $query->where('brand_id', $request->brand_id);
            })
            ->orderBy("id", "desc")
            ->paginate(8)
            ->withQueryString();

        return view('product.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $suppliers = Contact::where('type', 'supplier')
            ->orderBy('name')
            ->get(['id', 'name']);
            
        return view('product.create', compact('categories', 'brands', 'units', 'suppliers'));
    }

    /**
     * Store a newly created product in storage.
     * 
     * @param ProductStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ProductStoreRequest $request)
    {
        DB::beginTransaction();
        
        try {
            // Create the product
            $product = $this->createProduct($request);
            
            // Handle opening stock if requested
            if ($request->boolean('add_opening_stock')) {
                $this->createOpeningStockPurchase($product, $request);
            }

            DB::commit();
            
            // Log activity
            Log::info('Product created successfully', [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'with_opening_stock' => $request->boolean('add_opening_stock')
            ]);

            return $this->successResponse('Product successfully created', 'products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
                'request_data' => $request->except(['image'])
            ]);
            
            return $this->errorResponse('Failed to create product. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        try {
            $businessId = $this->getBusinessId();

            $query = Product::forUserBusiness()
                ->with(['category', 'brand', 'unit'])
                ->withSum([
                    'purchaseDetails as total_stock' => function ($query) use ($businessId) {
                        $query->where('business_id', $businessId);
                    }
                ], 'number_of_unsell');

            // Allow lookup by numeric id or slug
            if (is_numeric($id)) {
                $query->where('id', (int) $id);
            } else {
                $query->where('slug', $id);
            }

            $item = $query->firstOrFail();

            return view('product.show', compact('item'));
        } catch (\Exception $e) {
            Log::error('Product show failed: ' . $e->getMessage());
            flash()->error('Product not found or access denied.');
            return redirect()->route('products.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try {
            $product = Product::forUserBusiness()->findOrFail($id);
            $categories = Category::orderBy('name')->get();
            $brands = Brand::orderBy('name')->get();
            $units = Unit::orderBy('name')->get();
            $suppliers = Contact::where('type', 'supplier')
                ->orderBy('name')
                ->get(['id', 'name']);

            return view('product.edit', compact('product', 'categories', 'brands', 'units', 'suppliers'));
        } catch (\Exception $e) {
            Log::error('Product edit failed: ' . $e->getMessage());
            flash()->error('Product not found or access denied.');
            return redirect()->route('products.index');
        }
    }

    /**
     * Update the specified resource in storage.
     * 
     * @param ProductUpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $product = Product::forUserBusiness()->findOrFail($id);

            // Store old values for logging
            $oldValues = $product->getOriginal();

            // Update basic product information
            $product->fill([
                'name' => $request->name,
                'slug' => slug_generator($request->name),
                'category_id' => $request->category_id,
                'unit_id' => $request->unit_id,
                'brand_id' => $request->brand_id,
                'description' => $request->description,
                'sku' => $request->sku ?? $product->sku,
                'barcode_type' => $request->barcode_type,
                'alert_quantity' => $request->alert_quantity,
                'status' => $request->status,
                'not_for_selling' => $request->boolean('not_for_selling'),
                'selling_price_tax_type' => $request->selling_price_tax_type,
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $this->handleImageUpload($product, $request->file('image'));
            }

            $product->save();

            DB::commit();

            // Log changes
            Log::info('Product updated successfully', [
                'product_id' => $product->id,
                'user_id' => auth()->id(),
                'changes' => $product->getChanges()
            ]);

            flash()->success('Product updated successfully!');
            return redirect()->route('products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Product update failed', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            flash()->error('Failed to update product. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $product = Product::forUserBusiness()->findOrFail($id);
            
            // Check if product has any purchase details
            if ($product->purchaseDetails()->exists()) {
                flash()->warning('Cannot delete product with existing purchase records.');
                return redirect()->route('products.index');
            }

            $productName = $product->name;
            $product->delete();

            DB::commit();

            Log::info('Product deleted successfully', [
                'product_id' => $id,
                'product_name' => $productName,
                'user_id' => auth()->id()
            ]);

            flash()->success('Product successfully deleted');
            return redirect()->route('products.index');
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Product deletion failed', [
                'product_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);

            flash()->error('Failed to delete product. Please try again.');
            return redirect()->route('products.index');
        }
    }

    /**
     * Create a new product instance
     * 
     * @param ProductStoreRequest $request
     * @return Product
     */
    private function createProduct(ProductStoreRequest $request): Product
    {
        $product = new Product();
        $product->fill([
            'name' => $request->name,
            'slug' => slug_generator($request->name),
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'unit_id' => $request->unit_id,
            'brand_id' => $request->brand_id,
            'type' => 'single',
            'description' => $request->description,
            'sku' => $request->sku ?? sku_generator(),
            'barcode_type' => $request->barcode_type,
            'barcode' => $request->barcode,
            'alert_quantity' => $request->alert_quantity,
            'status' => $request->status ?? 'active',
            'not_for_selling' => $request->boolean('not_for_selling'),
            'selling_price_tax_type' => $request->selling_price_tax_type,
        ]);

        if ($request->hasFile('image')) {
            $product->images = $this->uploadProductImage($request->file('image'));
        }
        
        $product->save();
        return $product;
    }

    /**
     * Create opening stock purchase record
     * 
     * @param Product $product
     * @param ProductStoreRequest $request
     * @return void
     * @throws \Exception
     */
    private function createOpeningStockPurchase(Product $product, ProductStoreRequest $request): void
    {
        $businessId = $this->getBusinessId();
        
        // Validate opening stock data
        $this->validateOpeningStockData($request);
        
        // Calculate totals
        $quantity = $request->quantity;
        $purchasePrice = $request->purchase_price;
        $sellingPrice = $request->selling_price;
        $lineTotal = $quantity * $purchasePrice;
        
        // Create purchase record
        $purchase = Purchase::create([
            'business_id' => $businessId,
            'contact_id' => $request->supplier_id,
            'amount' => $lineTotal,
            'discount' => 0,
            'tax' => 0,
            'total' => $lineTotal,
        ]);

        // Create purchase detail record
        PurchaseDetails::create([
            'business_id' => $businessId,
            'purchase_id' => $purchase->id,
            'product_id' => $product->id,
            'quantity' => $quantity,
            'number_of_unsell' => $quantity, // Initially all unsold
            'purchase_price' => $purchasePrice,
            'selling_price' => $sellingPrice,
            'discount' => 0,
            'tax' => 0,
            'total' => $lineTotal,
        ]);
        
        Log::info('Opening stock created', [
            'product_id' => $product->id,
            'purchase_id' => $purchase->id,
            'quantity' => $quantity,
            'purchase_price' => $purchasePrice
        ]);
    }

    /**
     * Handle image upload for product
     * 
     * @param Product $product
     * @param \Illuminate\Http\UploadedFile $image
     * @return void
     * @throws \Exception
     */
    private function handleImageUpload(Product $product, $image): void
    {
        // Validate image
        if (!$image->isValid()) {
            throw new \Exception('Invalid image file.');
        }

        // Check file size (2MB max)
        if ($image->getSize() > 2 * 1024 * 1024) {
            throw new \Exception('Image size must be less than 2MB.');
        }

        // Delete old image if exists
        if ($product->images && Storage::exists($product->images)) {
            Storage::delete($product->images);
        }

        // Store new image
        $product->images = $this->uploadProductImage($image);
    }

    /**
     * Upload product image
     * 
     * @param \Illuminate\Http\UploadedFile $image
     * @return string
     */
    private function uploadProductImage($image): string
    {
        $path = $image->store('products/' . date('Y/m'), 'public');
        return $path;
    }

    /**
     * Validate opening stock data
     * 
     * @param ProductStoreRequest $request
     * @throws \Exception
     */
    private function validateOpeningStockData(ProductStoreRequest $request): void
    {
        if (!$request->supplier_id || !$request->quantity || !$request->purchase_price || !$request->selling_price) {
            throw new \Exception('Opening stock data is incomplete');
        }
        
        if ($request->quantity <= 0 || $request->purchase_price < 0 || $request->selling_price < 0) {
            throw new \Exception('Opening stock values must be positive');
        }
    }

    /**
     * Get business ID for current user
     * 
     * @return int
     * @throws \Exception
     */
    private function getBusinessId(): int
    {
        $businessId = auth()->user()->business_id ?? config('app.default_business_id');
        
        if (!$businessId) {
            throw new \Exception('Business ID not found');
        }
        
        return $businessId;
    }

    /**
     * Return success response
     * 
     * @param string $message
     * @param string $route
     * @return \Illuminate\Http\RedirectResponse
     */
    private function successResponse(string $message, string $route): \Illuminate\Http\RedirectResponse
    {
        flash()->success($message);
        return redirect()->route($route);
    }

    /**
     * Return error response
     * 
     * @param string $message
     * @return \Illuminate\Http\RedirectResponse
     */
    private function errorResponse(string $message): \Illuminate\Http\RedirectResponse
    {
        flash()->error($message);
        return redirect()->back()->withInput();
    }
}