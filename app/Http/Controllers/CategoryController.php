<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryStoreAndUpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
     * Store a newly created resource in storage via AJAX.
     * 
     * @param CategoryStoreAndUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxStore(CategoryStoreAndUpdateRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $category = new Category();
            $category->name = $request->name;
            $category->code = $request->code;
            $category->description = $request->description;

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
                
                // Store image
                $category->image = $image->store('categories', 'public');
            }

            $category->save();
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'code' => $category->code
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            \Log::error('Category creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create category. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
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
