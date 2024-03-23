<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Jobs\NotifyAdminJob;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }
    public function index()
    {
        $this->authorize('view','App\Models\Product');
        $products = Product::filterBy(request()->all())->get();
        if ($products)
            return response()->json([
                "message" => "all products",
                "products" => $products
            ], 200);

    }

    public function store(ProductRequest $request)
    {
        $this->authorize('create','App\Models\Product');
        $request->validated();
        return DB::transaction(function () use ($request) {
            $product = $this->productService->create($request->except('images'));
            $images = $this->productService->handleUploadedImages($request->file('images'), $product);
            $this->productService->saveImages($images, $product);
            ///////////////////////
            NotifyAdminJob::dispatch(Auth::user(), $product);
            //////////////////////
            return response()->json(
                [
                    "message" => "The product added successfully, please wait to accept it by admin.",
                    "product" => $product
                ],
                201
            );
        });

    }

    public function show($id)
    {
        $this->authorize('view','App\Models\Product');
        $product = $this->productService->getById($id);
        if (!$product)
            return response()->json(["message" => "product not found"], 404);

        return response()->json($product);

    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = $this->productService->getById($id);
        $this->authorize('update',$product);
        if (!$product)
            return response()->json(["message" => "product not found"], 404);

        $request->validated();

        return DB::transaction(function () use ($request, $product) {
            $this->productService->update($product, $request->except('images'));

            if ($request->hasFile('image') && ($images = $this->productService->handleUploadedImages($request->file('images'), $product))) {
                $productImages = $this->productService->saveImages($images, $product);
                if (!$productImages)
                    return response()->json(["product" => $product, "message" => "image not saved"]);
            }

            return response()->json(
                [
                    "product" => $product,
                    "message" => "Product updated successfully"
                ],
                202
            );
        });
    }

    public function destroy($id)
    {
        $product = $this->productService->getById($id);
        $this->authorize('delete',$product);
        if (!$product)
            return response()->json(["message" => "product not found"], 404);
        return DB::transaction(function () use ($product) {
            if ($product->images()->delete() && $this->productService->delete($product)) {
                return response()->json(["message" => "Product deleted successfully"], 202);
            }
        });

    }
}
