<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($request) {
            $category = $this->categoryService->create($request->except('image'));

            if ($request->hasFile('image') && ($image = $this->categoryService->handleUploadedImage($request->file('image'), $category))) {
                $categoryImage = $this->categoryService->saveImage($image, $category);

                if (!$categoryImage) {
                    return response()->json(["category" => $category, "message" => "Image not saved"]);
                }
            }

            return response()->json(["category" => $category, "message" => "Category added successfully"], 201);
        });
    }

    public function show($id)
    {
        $category = $this->categoryService->getById($id);
        if (!$category) {
            return response()->json($category);
        } else {
            return response()->json(["message" => "category not found"], 404);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $category = $this->categoryService->getById($id);
        if (!$category) {
            return response()->json(["message" => "category not found"], 404);
        }
        $request->validated();
        return DB::transaction(function () use ($request, $category) {
            $this->categoryService->update($category, $request->except('image'));

            if ($request->hasFile('image') && ($image = $this->categoryService->handleUploadedImage($request->file('image'), $category))) {
                $categoryImage = $this->categoryService->updateImage($image, $category);

                if (!$categoryImage) {
                    return response()->json(["category" => $category, "message" => "Image not saved"]);
                }
            }

            return response()->json(["category" => $category, "message" => "Category updated successfully"], 202);
        });
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getById($id);
        if ($category) {
            return DB::transaction(function () use ($category) {
                if ($this->categoryService->deleteImage($category) && $this->categoryService->delete($category)) {
                    return response()->json(["message" => "Category deleted successfully"], 202);
                }
            });
        }

        return response()->json(["message" => "Category not found"], 404);
    }
}
