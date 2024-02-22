<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;

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
        $request->validated();
        $category = $this->categoryService->create($request->except('image'));
        if ($category) {
            if ($request->hasFile('image')) {
                if ($image = $this->categoryService->handleUploadedImage($request->file('image'), $category)) {
                    $categoryImage = $this->categoryService->saveImage($image, $category);
                    if ($categoryImage)
                        return response()->json(["category" => $category, "message" => "category added successfully"], 201);
                    else {
                        return response()->json(["category" => $category, "message" => "image not saved"]);
                    }
                }
            }
            return response()->json(
                [
                    "category" => $category,
                    "message" => "category added successfully"
                ],
                201
            );
        }
        return response()->json(["message" => "category not saved"]);

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

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->getById($id);
        if ($category != null) {
            $request->validated();
            $this->categoryService->update($category, $request->except('image'));
            if ($request->hasFile('image')) {
                if ($image = $this->categoryService->handleUploadedImage($request->file('image'), $category)) {
                    $categoryImage = $this->categoryService->updateImage($image, $category);
                    if ($categoryImage)
                        return response()->json(["category" => $category, "message" => "category updated with image successfully"], 202);
                    else {
                        return response()->json(["category" => $category, "message" => "image not saved"]);
                    }
                }
            }
            return response()->json(["message" => "category updated successfully"], 202);
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getById($id);
        if ($category != null) {
            if ($this->categoryService->deleteImage($category) &&$this->categoryService->delete($category)) {
                return response()->json(["message" => "category deleted successfully"], 202);
            }
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }
}
