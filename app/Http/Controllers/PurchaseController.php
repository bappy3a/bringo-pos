<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\PurchaseStoreRequest;
use App\Http\Requests\Purchase\PurchaseUpdateRequest;
use App\Http\Requests\Purchase\PurchaseReturnRequest;
use App\Models\Contact;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\New_;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::forUserBusiness()
        ->with(["user:id,first_name,last_name"])
        ->orderBy("created_at","desc")
        ->paginate(10);
        return view("purchase.index", compact("purchases"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Contact::forUserBusiness()->whereType('supplier')->orderBy('name')->get();
        return view("purchase.create",compact("suppliers"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PurchaseStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            
            // Calculate totals
            $total = collect($request->purchase_price)->sum();
            $discount = collect($request->discount ?? [])->sum();
            $tax = collect($request->tax ?? [])->sum();
            // Create purchase record
            $purchase = Purchase::create([
                'user_id' => Auth::id(),
                'location_id' => Auth::user()->location_id,
                'business_id' => Auth::user()->business_id,
                'transaction_id' => $request->transaction_id,
                'contact_id' => $request->contact_id,
                'date' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->date),
                'amount' => $total,
                'paid' => $total,
                'due' => 0,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total + $tax - $discount,
                'payment_status' => 'paid',
                'reference_no' => $request->reference_no,
                'note' => $request->note,
            ]);

            // Create purchase details for each product
            $purchaseDetails = [];
            foreach ($request->product_id as $key => $productId) {
                $quantity = $request->quantity[$key];
                $purchasePrice = $request->purchase_price[$key];
                $sellingPrice = $request->selling_price[$key];
                $itemDiscount = $request->discount[$key] ?? 0;
                $itemTax = $request->tax[$key] ?? 0;
                
                $purchaseDetails[] = [
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'location_id' => Auth::user()->location_id,
                    'business_id' => Auth::user()->business_id,
                    'quantity' => $quantity,
                    'number_of_unsell' => $quantity,
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'discount' => $itemDiscount,
                    'tax' => $itemTax,
                    'total' => ($quantity * $purchasePrice) + $itemTax - $itemDiscount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Bulk insert purchase details
            PurchaseDetails::insert($purchaseDetails);
            
            DB::commit();
            
            flash()->success('Purchase successfully created!');
            return redirect()->route('purchases.index');
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            
            flash()->error('Failed to create purchase. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        // Check if user has permission to view this purchase
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to view this purchase.');
            return redirect()->route('purchases.index');
        }

        $purchaseDetails = $purchase->purchaseDetails()->with('product')->get();
        
        return view("purchase.show", compact("purchase", "purchaseDetails"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        // Check if user has permission to edit this purchase
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to edit this purchase.');
            return redirect()->route('purchases.index');
        }

        $suppliers = Contact::forUserBusiness()->whereType('supplier')->orderBy('name')->get();
        $purchaseDetails = $purchase->purchaseDetails()->with('product')->get();
        
        return view("purchase.edit", compact("purchase", "suppliers", "purchaseDetails"));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PurchaseUpdateRequest $request, Purchase $purchase)
    {
        // Check if user has permission to update this purchase
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to update this purchase.');
            return redirect()->route('purchases.index');
        }

        try {
            DB::beginTransaction();
            
            // Calculate totals
            $total = collect($request->purchase_price)->sum();
            $discount = collect($request->discount ?? [])->sum();
            $tax = collect($request->tax ?? [])->sum();
            
            // Update purchase record
            $purchase->update([
                'contact_id' => $request->contact_id,
                'date' => \Carbon\Carbon::createFromFormat('d-m-Y', $request->date),
                'amount' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total + $tax - $discount,
                'reference_no' => $request->reference_no,
                'note' => $request->note,
                'transaction_id' => $request->transaction_id,
            ]);

            // Delete existing purchase details
            $purchase->purchaseDetails()->delete();

            // Create new purchase details for each product
            $purchaseDetails = [];
            foreach ($request->product_id as $key => $productId) {
                $quantity = $request->quantity[$key];
                $purchasePrice = $request->purchase_price[$key];
                $sellingPrice = $request->selling_price[$key];
                $itemDiscount = $request->discount[$key] ?? 0;
                $itemTax = $request->tax[$key] ?? 0;
                
                $purchaseDetails[] = [
                    'purchase_id' => $purchase->id,
                    'product_id' => $productId,
                    'location_id' => Auth::user()->location_id,
                    'business_id' => Auth::user()->business_id,
                    'quantity' => $quantity,
                    'number_of_unsell' => $quantity,
                    'purchase_price' => $purchasePrice,
                    'selling_price' => $sellingPrice,
                    'discount' => $itemDiscount,
                    'tax' => $itemTax,
                    'total' => ($quantity * $purchasePrice) + $itemTax - $itemDiscount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            
            // Bulk insert new purchase details
            PurchaseDetails::insert($purchaseDetails);
            
            DB::commit();
            
            flash()->success('Purchase successfully updated!');
            return redirect()->route('purchases.index');
            
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            
            flash()->error('Failed to update purchase. Please try again.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        // Check if user has permission to delete this purchase
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to delete this purchase.');
            return redirect()->route('purchases.index');
        }

        try {
            DB::beginTransaction();
            
            // Delete purchase details first
            $purchase->purchaseDetails()->delete();
            
            // Delete the purchase
            $purchase->delete();
            
            DB::commit();
            
            flash()->success('Purchase successfully deleted!');
            return redirect()->route('purchases.index');
            
        } catch (\Exception $e) {
            DB::rollback();
            
            flash()->error('Failed to delete purchase. Please try again.');
            return redirect()->back();
        }
    }

    /**
     * Show purchase return form.
     */
    public function returnForm(Purchase $purchase)
    {
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to return this purchase.');
            return redirect()->route('purchases.index');
        }

        $purchase->load(['purchaseDetails.product']);
        return view('purchase.return', compact('purchase'));
    }

    /**
     * Store purchase return.
     */
    public function returnStore(PurchaseReturnRequest $request, Purchase $purchase)
    {
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to return this purchase.');
            return redirect()->route('purchases.index');
        }

        try {
            DB::beginTransaction();

            $totalDeltaAmount = 0;

            // Map desired total returned per product
            $desiredReturnedByProduct = [];
            foreach ($request->product_id as $idx => $productId) {
                $desiredReturnedByProduct[(int)$productId] = (float)($request->return_quantity[$idx] ?? 0);
            }

            // Iterate details and adjust based on delta between desired and current returned
            $details = $purchase->purchaseDetails()->get();
            foreach ($details as $detail) {
                $productId = (int)$detail->product_id;
                $currentReturned = (float)($detail->quantity_returned ?? 0);
                $desiredReturned = (float)($desiredReturnedByProduct[$productId] ?? 0);

                // Clamp desired to purchased qty
                $desiredReturned = max(0, min($desiredReturned, (float)$detail->quantity + $currentReturned));
                $delta = $desiredReturned - $currentReturned; // positive = more return, negative = reduce return
                if ($delta == 0) { continue; }

                // Available unsold units that can be returned additionally
                if ($delta > 0) {
                    $additionalReturn = min($delta, (float)$detail->number_of_unsell);
                    if ($additionalReturn <= 0) { continue; }
                    $detail->number_of_unsell = max(0, (float)$detail->number_of_unsell - $additionalReturn);
                    $detail->quantity_returned = $currentReturned + $additionalReturn;
                    $lineReduction = $additionalReturn * (float)$detail->purchase_price;
                    $detail->total = max(0, (float)$detail->total - $lineReduction);
                    $totalDeltaAmount += $lineReduction;
                } else {
                    // Reducing previously returned quantity (restock)
                    $restock = min(abs($delta), $currentReturned);
                    if ($restock <= 0) { continue; }
                    $detail->number_of_unsell = (float)$detail->number_of_unsell + $restock;
                    $detail->quantity_returned = max(0, $currentReturned - $restock);
                    $lineIncrease = $restock * (float)$detail->purchase_price;
                    $detail->total = (float)$detail->total + $lineIncrease;
                    $totalDeltaAmount -= $lineIncrease;
                }

                $detail->save();
            }

            // Update purchase summary based on delta
            $purchase->amount = max(0, (float)$purchase->amount - $totalDeltaAmount);
            $purchase->total = $purchase->purchaseDetails()->sum('total');
            $purchase->paid = min($purchase->paid, $purchase->total);
            $purchase->due = max(0, $purchase->total - $purchase->paid);
            $purchase->note = trim(($purchase->note ? $purchase->note."\n" : '') . 'Returns updated on ' . now()->format('d-m-Y') . ($request->reason ? (': '.$request->reason) : ''));
            $purchase->save();

            DB::commit();

            flash()->success('Purchase returns saved.');
            return redirect()->route('purchases.show', $purchase->id);
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to save purchase returns.');
            return redirect()->back()->withInput();
        }
    }

    public function returnClear(Purchase $purchase)
    {
        if ($purchase->business_id !== Auth::user()->business_id) {
            flash()->error('You do not have permission to clear returns.');
            return redirect()->route('purchases.index');
        }

        try {
            DB::beginTransaction();

            $details = $purchase->purchaseDetails()->get();
            $totalIncrease = 0;
            foreach ($details as $detail) {
                $returned = (float)($detail->quantity_returned ?? 0);
                if ($returned > 0) {
                    // Restock all returned units
                    $detail->number_of_unsell = (float)$detail->number_of_unsell + $returned;
                    $detail->quantity_returned = 0;
                    $lineIncrease = $returned * (float)$detail->purchase_price;
                    $detail->total = (float)$detail->total + $lineIncrease;
                    $totalIncrease += $lineIncrease;
                    $detail->save();
                }
            }

            // Update purchase summary back up
            $purchase->amount = (float)$purchase->amount + $totalIncrease;
            $purchase->total = $purchase->purchaseDetails()->sum('total');
            $purchase->paid = min($purchase->paid, $purchase->total);
            $purchase->due = max(0, $purchase->total - $purchase->paid);
            $purchase->note = trim(($purchase->note ? $purchase->note."\n" : '') . 'Returns cleared on ' . now()->format('d-m-Y'));
            $purchase->save();

            DB::commit();

            flash()->success('All returns cleared.');
            return redirect()->route('purchases.show', $purchase->id);
        } catch (\Exception $e) {
            DB::rollBack();
            flash()->error('Failed to clear returns.');
            return redirect()->back();
        }
    }

    /**
     * Display a listing of purchase returns.
     */
    public function returnsIndex()
    {
        $purchases = Purchase::forUserBusiness()
            ->whereHas('purchaseDetails', function($q){
                $q->where(function($qq){
                    $qq->whereNotNull('quantity_returned')
                       ->where('quantity_returned', '>', 0);
                });
            })
            ->with(['user:id,first_name,last_name','contact:id,name'])
            ->orderBy('created_at','desc')
            ->paginate(10);

        return view('purchase.returns', compact('purchases'));
    }
}
