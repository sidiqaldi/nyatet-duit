<?php

namespace App\Http\Controllers;

use App\Events\CategoryDeleted;
use App\Events\CategoryUpdated;
use App\Http\Requests\Category\IndexRequest;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
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

        $category = $request->user()->categories()->create($data);

        if ($request->requestNonInertia) {
            return response()->json(['data' => $category]);
        }

        return redirect()->back()->with('success', 'New category added.');
    }

    public function update(UpdateRequest $request, Category $category)
    {
        Gate::authorize('update', $category);

        $data = $request->validated();

        $oldType = $category->type;

        $category->fill($data);

        if ($category->isDirty()) {

            $category->save();

            CategoryUpdated::dispatch($category, $oldType);
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
