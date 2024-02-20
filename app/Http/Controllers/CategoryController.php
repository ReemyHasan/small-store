<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index()
    {
        $categories = $this->categoryService->getAll();
        if ($categories)
            return response()->json([
                "message" => "all categories",
                "categories" => $categories
            ], 200);
    }

    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $category = $this->categoryService->create($validated);
        if ($category)
            return response()->json(
                [
                    "category" => $category,
                    "message" => "category added successfully"
                ],
                201
            );
    }

    public function show($id)
    {
        $category = $this->categoryService->getById($id);
        if ($category != null) {
            return response()->json($category);
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = $this->categoryService->getById($id);
        if ($category != null) {
            $validated = $request->validated();
            $this->categoryService->update($category, $validated);
            return response()->json(["message" => "category updated successfully"], 202);
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getById($id);
        if ($category != null) {
            $this->categoryService->delete($category);
            return response()->json(["message" => "category deleted successfully"], 202);
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }
}
