<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Category::class);

        return Category::all();
    }

    public function store(CategoryRequest $request): Category
    {
        $this->authorize('create', Category::class);

        return Category::create($request->validated());
    }

    public function show(Category $category): Category
    {
        $this->authorize('view', $category);

        return $category;
    }

    public function update(CategoryRequest $request, Category $category): Category
    {
        $this->authorize('update', $category);

        $category->update($request->validated());

        return $category;
    }

    public function destroy(Category $category): Response
    {
        $this->authorize('delete', $category);

        if ($category->tickets()->exists()) {
            abort(422, 'Category is used by tickets');
        }

        $category->delete();

        return response()->noContent();
    }
}
