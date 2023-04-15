<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function store(CategoryRequest $request): Category
    {
        return Category::create($request->validated());
    }

    public function show(Category $category): Category
    {
        return $category;
    }

    public function update(CategoryRequest $request, Category $category): Category
    {
        $category->update($request->validated());

        return $category;
    }

    public function destroy(Category $category): Response
    {
        if ($category->tickets()->exists()) {
            abort(422, 'Category is used by tickets');
        }

        $category->delete();

        return response()->noContent();
    }
}
