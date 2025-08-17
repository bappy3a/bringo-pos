<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\UnitStoreAndUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brandes = Brand::forUserBusiness()->latest()->get();
        return view('brand.index',compact('brandes'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitStoreAndUpdateRequest $request)
    {
        $unit = New Brand();
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->save();
        flash()->success('Brand successfully created');
        return redirect()->back();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Brand::findOrFail($id);
        return view('brand.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitStoreAndUpdateRequest $request, $id)
    {
        $unit = Brand::findOrFail($id);
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->save();
        flash()->success('Brand successfully update');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = Brand::findOrFail($id);
        $unit->delete();
        flash()->success('Brand successfully delete!');
        return redirect()->back();
    }
}
