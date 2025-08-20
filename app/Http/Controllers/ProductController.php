<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get(['id', 'name']);
        $brands = Brand::orderBy('name')->get(['id', 'name']);

        $businessId = auth()->user()->business_id; // or however you get business_id

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
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        $units = Unit::all();
        $suppliers = Contact::where('type', 'supplier')->get();
        return view('product.create', compact('categories', 'brands', 'units', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = slug_generator($request->name);
        $product->user_id = auth()->user()->id;
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->brand_id = $request->brand_id;
        $product->type = 'single';
        $product->description = $request->description;
        $product->sku = $request->sku ?? sku_generator();
        $product->barcode_type = $request->barcode_type;
        $product->barcode = $request->barcode;
        $product->alert_quantity = $request->alert_quantity;
        $product->status = $request->status ?? "active";
        $product->not_for_selling = $request->not_for_selling;
        $product->selling_price_tax_type = $request->selling_price_tax_type;

        if ($request->hasFile('image')) {
            $product->images = $request->file('image')->store('uploads');
        }
        $product->save();
        flash()->success('Product successfully created');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $item = Product::findOrFail($id);
        return view('product.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     * 
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            $categories = Category::all();
            $brands = Brand::all();
            $units = Unit::all();
            $suppliers = Contact::where('type', 'supplier')->get();

            return view('product.edit', compact('product', 'categories', 'brands', 'units', 'suppliers'));
        } catch (\Exception $e) {
            \Log::error('Product edit failed: ' . $e->getMessage());
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

            $product = Product::findOrFail($id);

            // Update basic product information
            $product->name = $request->name;
            $product->slug = slug_generator($request->name);
            $product->category_id = $request->category_id;
            $product->unit_id = $request->unit_id;
            $product->brand_id = $request->brand_id;
            $product->description = $request->description;
            $product->sku = $request->sku ?? $product->sku;
            $product->barcode_type = $request->barcode_type;
            $product->alert_quantity = $request->alert_quantity;
            $product->status = $request->status;
            $product->not_for_selling = $request->not_for_selling;
            $product->selling_price_tax_type = $request->selling_price_tax_type;

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');

                // Validate image
                if (!$image->isValid()) {
                    throw new \Exception('Invalid image file.');
                }

                // Check file size (2MB max)
                if ($image->getSize() > 2 * 1024 * 1024) {
                    throw new \Exception('Image size must be less than 2MB.');
                }

                // Delete old image if exists
                if ($product->images && Storage::disk('public')->exists($product->images)) {
                    Storage::disk('public')->delete($product->images);
                }

                // Store new image
                $product->images = $request->file('image')->store('uploads');
            }

            $product->save();

            DB::commit();

            flash()->success('Product updated successfully!');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Product update failed: ' . $e->getMessage());

            flash()->error('Failed to update product. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        flash()->success('Product  successfully delete');
        return redirect()->route('products.index');
    }
}
