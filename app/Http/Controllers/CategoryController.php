<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryIndexRequest;
use App\Http\Resources\CategoryResource;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index(CategoryIndexRequest $request)
    {
        $categories = CategoryResource::collection($request->user()->categories);

        return Inertia::render('Category/Index', compact('categories'));
    }
}
