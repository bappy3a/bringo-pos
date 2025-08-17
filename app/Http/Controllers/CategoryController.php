<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStoreAndUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

use function Flasher\Prime\flash;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys = Category::forUserBusiness()->latest()->get();
        return view('category.index',compact('categorys'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreAndUpdateRequest $request)
    {
        
        $category = New Category();
        $category->name = $request->name;
        $category->code = $request->code;
        $category->description = $request->description;

        if ($request->hasFile('image')) {
            $category->image =  $request->file('image')->store('uploads');
        }

        $category->save();
        flash()->success('Category successfully created');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Category::findOrFail($id);
        return view('category.edit',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryStoreAndUpdateRequest $request,$id)
    {
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->code = $request->code;
        $category->description = $request->description;
        if ($request->hasFile('image')) {
            $category->image =  $request->file('image')->store('uploads');
        }

        $category->save();
        flash()->success('Category successfully update');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        flash()->success('Category successfully delete!');
        return redirect()->back();
    }
}
