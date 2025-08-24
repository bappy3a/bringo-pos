<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\PurchaseStoreRequest;
use App\Models\Contact;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::forUserBusiness()
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
        $total = collect($request->purchase_price)->sum();
        $purchase = New Purchase();
        $purchase->user_id = $request->user()->id;
        $purchase->location_id = $request->location_id;
        $purchase->transaction_id = $request->transaction_id;
        $purchase->contact_id = $request->contact_id;
        $purchase->date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date);
        $purchase->amount = $total;
        $purchase->paid = $total;
        $purchase->due = 0;
        $purchase->discount = collect($request->discount)->sum();
        $purchase->tax = collect($request->tax)->sum();
        $purchase->total = $total;
        $purchase->payment_status = 'pay';
        $purchase->reference_no = $request->reference_no;
        $purchase->note = $request->note;
        $purchase->save();

        $location = auth()->user()->location_id;

        foreach ($request->product_id as $key=>$id) {
            $purchaseDetails = New PurchaseDetails();
            $purchaseDetails->product_id = $id;
            $purchaseDetails->location_id = $location;
            $purchaseDetails->purchase_id = $purchase->id;
            $purchaseDetails->quantity = $request->quantity[$key];
            $purchaseDetails->number_of_unsell = 0;
            $purchaseDetails->purchase_price = $request->purchase_price[$key];
            $purchaseDetails->selling_price = $request->selling_price[$key];
            $purchaseDetails->discount = $request->discount[$key] ?? 0;
            $purchaseDetails->tax = $request->tax[$key] ?? 0;
            $purchaseDetails->total = $request->quantity[$key] * $request->purchase_price[$key];
            $purchaseDetails->save();
        }
        flash()->success('Purchases successfully created');
        return redirect()->route('purchases.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
