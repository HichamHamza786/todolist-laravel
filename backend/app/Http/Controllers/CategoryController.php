<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        return response()->json($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $title = $request->input('title');
        $category = new Category();
        $category->title = $title;

        if ($category->save()) {
            return response()->json($category, 201);
        } else {
            return response(null, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response(null, 404);
        }

        $title = $request->input('title');
        $category->title = $title;

        if ($title->save()) {
            return response()->json($category);
        } else {
            return response(null, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return response(null, 404);
        }

        if ($category->delete()) {
            return response(null, 200);
        } else {
            return response(null, 500);
        }
    }
}
