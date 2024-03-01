<?php

namespace App\Services;

use App\Models\Category;
use App\Traits\CommonService;

class CategoryService
{
    use CommonService;
    public function getAll()
    {
<<<<<<< HEAD
        $categories = Category::getAll();
=======
        $categories = Category::with('subcategories')->where('supercategory_id', 0)->with('subcategories')->get();
>>>>>>> 4b60e833342e3553e2d990998f227c8c4682565a
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
