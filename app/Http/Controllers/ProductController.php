<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $products = $this->productService->getAll();
        if ($products)
            return response()->json([
                "message" => "all products",
                "products" => $products
            ], 200);

    }

    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $validated['image'] = $this->productService->handleUploadedImage($request->file('image'), null);
        }
        $product = $this->productService->create($validated);
        if ($product)
            return response()->json(["product" => $product, "message" => "product added successfully"], 201);
    }

    public function show($id)
    {
        $product = $this->productService->getById($id);
        if ($product != null) {
            return response()->json($product);

        } else {
            return response()->json(["message" => "product not found"], 404);
        }
    }

    public function update(ProductRequest $request, $id)
    {
        $product = $this->productService->getById($id);
        if ($product != null) {
            $validated = $request->validated();
            if ($request->hasFile('image')) {
                $validated['image'] = $this->productService->handleUploadedImage($request->file('image'), $product);
            }
            $this->productService->update($product, $validated);
            return response()->json(["message" => "product updated successfully"], 202);
        } else {
            return response()->json(["message" => "product not found"], 404);
        }
    }

    public function destroy($id)
    {
        $product = $this->productService->getById($id);
        if ($product != null) {
            $this->productService->delete($product);
            return response()->json(["message" => "product deleted successfully"], 202);
        } else {
            return response()->json(["message" => "product not found"], 404);
        }
    }
}
