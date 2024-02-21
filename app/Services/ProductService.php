<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function getAll()
    {
        $products = Product::getRecords();
        return $products;
    }
    public function create($data)
    {
        return Product::create($data);
    }
    public function getById($id)
    {
        return Product::getRecord($id);
    }
    public function update($product, $validated)
    {
        return $product->update($validated);
    }
    public function delete($product)
    {
        return $product->delete();
    }
    public function handleUploadedImage($image, $product)
    {
        return HandleUploadedImage($image,$product,'products');
    }

    public function handleUploadedImages($images, $product)
    {
        $productImages = [];
        foreach ($images as $key => $value) {
            $productImage = $this->handleUploadedImage($value, $product);
            if ($productImage !== null)
                $productImages[] = ['url' => $productImage];
        }
        return $productImages;
    }
    public function getMyProduct()
    {
        $products = Product::getRecords()->where('vendor_id', '=', Auth::user()->id)->get();
        return $products;
    }
    public function saveImages($images, $product)
    {
        $productImages = $product->images()->createMany($images);
        return $productImages;
    }
}
