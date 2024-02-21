<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

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
        $request->validated();
        // lad($request->file('images')[0]);
        $product = $this->productService->create($request->except('images'));
        if ($product) {
            if ($request->hasFile('images')) {
                if ($images = $this->productService->handleUploadedImages($request->file('images'), $product)) {
                    $productImages = $this->productService->saveImages($images, $product);
                    if ($productImages)
                        return response()->json(["product" => $product, "message" => "product added successfully"], 201);
                    else {
                        return response()->json(["product" => $product, "message" => "image not saved"]);
                    }
                }
            }
            return response()->json(
                [
                    "product" => $product,
                    "message" => "product added successfully"
                ],
                201
            );
        }
        return response()->json(["message" => "product not saved"]);

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

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->getById($id);
        if ($product != null) {
            $request->validated();
            $this->productService->update($product, $request->except('images'));
            if ($product) {
                if ($request->hasFile('images')) {
                    if ($images = $this->productService->handleUploadedImages($request->file('images'), $product)) {
                        $productImages = $this->productService->saveImages($images, $product);
                        if ($productImages)
                            return response()->json(["product" => $product, "message" => "product updated successfully"], 201);
                        else {
                            return response()->json(["product" => $product, "message" => "image not saved"]);
                        }
                    }
                }
                return response()->json(
                    [
                        "product" => $product,
                        "message" => "product updated without images successfully"
                    ],
                    202
                );
            }
        } else {
            return response()->json(["message" => "product not found"], 404);
        }
    }

    public function destroy($id)
    {
        $product = $this->productService->getById($id);
        if ($product != null) {
            $product->images()->delete();
            $this->productService->delete($product);
            return response()->json(["message" => "product deleted successfully"], 202);
        } else {
            return response()->json(["message" => "product not found"], 404);
        }
    }
}
