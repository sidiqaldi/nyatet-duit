<?php

namespace App\Http\Controllers;

use App\Events\CategoryDeleted;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(IndexRequest $request)
    {
        $categories = CategoryResource::collection($request->user()->categories);

        return Inertia::render('Category/Index', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $request->user()->categories()->create($data);

        return redirect()->back()->with('success', 'New category added.');
    }

    public function update(StoreRequest $request, Category $category)
    {
        Gate::authorize('update', $category);

        $data = $request->validated();

        $category->fill($data);

        if ($category->isDirty()) {

            $category->save();
        }

        return redirect()->back()->with('success', 'Category edited.');
    }

    public function destroy(Category $category)
    {
        Gate::authorize('delete', $category);

        $categoryId = $category->id;

        $category->delete();

        CategoryDeleted::dispatch($categoryId);

        return redirect()->back()->with('success', 'Transaction deleted.');
    }
}
