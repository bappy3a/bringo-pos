<?php

namespace App\Http\Controllers;

use App\Http\Requests\Brand\BrandStoreAndUpdateRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function store(BrandStoreAndUpdateRequest $request)
    {
        $unit = New Brand();
        $unit->name = $request->name;
        $unit->description = $request->description;
        $unit->save();
        flash()->success('Brand successfully created');
        return redirect()->back();

    }

    /**
     * Store a newly created resource in storage via AJAX.
     * 
     * @param BrandStoreAndUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxStore(BrandStoreAndUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->description = $request->description;
            $brand->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Brand created successfully!',
                'brand' => [
                    'id' => $brand->id,
                    'name' => $brand->name
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Brand creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create brand. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
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
    public function update(BrandStoreAndUpdateRequest $request, $id)
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
