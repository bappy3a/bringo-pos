<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\ContactStoreRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->type == 'customer') {
            $contacts = Contact::whereIn('type',['customer','both'])->get();
            return view('contact.customer',compact('contacts'));
        }
        if ($request->type == 'supplier'){
            $contacts = Contact::whereIn('type',['supplier','both'])->get();
            return view('contact.supplier',compact('contacts'));
        }
        abort(404);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactStoreRequest $request)
    {
        $customer = New Contact();
        $customer->type = $request->type;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();
        flash()->success('Customer Added Successfully');
        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Contact::findOrFail($id);
        return view('contact.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Contact::findOrFail($id);
        $customer->type = $request->type;
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->save();
        flash()->success('Customer Updated Successfully');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Contact::findOrFail($id);
        $customer->delete();
        flash()->success('Customer Deleted Successfully');
        return redirect()->back();
    }
}
