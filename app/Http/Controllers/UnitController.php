<?php

namespace App\Http\Controllers;

use App\Http\Requests\Unit\UnitStoreAndUpdateRequest;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::forUserBusiness()->latest()->get();
        return view('unit.index',compact('units'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitStoreAndUpdateRequest $request)
    {
        $unit = New Unit();
        $unit->name = $request->name;
        $unit->allow_decimal = $request->allow_decimal ?? false;
        $unit->description = $request->description;
        $unit->save();
        flash()->success('Unit successfully created');
        return redirect()->back();

    }

    /**
     * Store a newly created resource in storage via AJAX.
     * 
     * @param UnitStoreAndUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxStore(UnitStoreAndUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $unit = new Unit();
            $unit->name = $request->name;
            $unit->allow_decimal = $request->allow_decimal ?? false;
            $unit->description = $request->description;
            $unit->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Unit created successfully!',
                'unit' => [
                    'id' => $unit->id,
                    'name' => $unit->name,
                    'allow_decimal' => $unit->allow_decimal
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Unit creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create unit. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Unit::findOrFail($id);
        return view('unit.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitStoreAndUpdateRequest $request, $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->name = $request->name;
        $unit->allow_decimal = $request->allow_decimal ?? false;
        $unit->description = $request->description;
        $unit->save();
        flash()->success('Unit successfully update');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $unit = Unit::findOrFail($id);
        $unit->delete();
        flash()->success('Unit successfully delete!');
        return redirect()->back();
    }
}
