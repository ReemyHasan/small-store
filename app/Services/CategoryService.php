<?php

namespace App\Services;
use App\Models\Category;
class CategoryService
{
    public function getAll(){
        $categories = Category::getRecords();
        return $categories;
    }
    public function create($data){
        return Category::create($data);
    }
    public function getById($id){
        return Category::getRecord($id);
    }
    public function update($category, $validated){
        return $category->update($validated);
    }
    public function delete($category){
        return $category->delete();
    }
    public function handleUploadedImage($image, $category)
    {
        return HandleUploadedImage($image,$category,'categories');
    }
    public function saveImage($image, $category)
    {
        return $category->image()->create(
            [
                'url' => $image,
            ]
        );
    }
}
