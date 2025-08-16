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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
