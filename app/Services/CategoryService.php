<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\CommonService;

class CategoryService
{
    use CommonService;
    public function getAll()
    {
        $categories =Category::with(['subcategories', 'products.user'])->parent()->get();

        return $categories;
    }
    public function create($data)
    {
        return Category::create($data);
    }
    public function getById($id)
    {
        return Category::getRecord($id);
    }
    public function handleUploadedImage($image, $category)
    {
        return HandleUploadedImage($image, $category, 'categories');
    }
}
