<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
        ]);

        return Category::create($request->validated());
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'title' => ['required'],
        ]);

        $category->update($request->validated());

        return $category;
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json();
    }
}
