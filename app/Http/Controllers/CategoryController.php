<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|unique:categories'
        ],[
            "name.unique" => "Category already exists"
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        Category::create($request->all());
        return response()->json(['success' => true, 'message' => 'Category registered'], 200);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|unique:categories'
        ],[
            "name.unique" => "Category already exists"
        ]);

        if ($validator->fails()){
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        $category->update($request->all());
        return response()->json(['success' => true, 'message' => 'Category updated'], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(['success' => true, 'message' => 'Category deleted'], 200);
    }
}
