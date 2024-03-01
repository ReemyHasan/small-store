<?php

namespace App\Models;

use App\Traits\CreatedFrom;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Category extends BaseModel
{
    use HasFactory, CreatedFrom,ImageAttribute;
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];
    protected $with = [
        "products",
    ];
    protected $appends = array("created_from", "image_url");
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    public function products(){
        return $this->hasMany(Product::class,'category_id')->filter();
    }

    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }
    public static function getAll()
    {
        $rootCategories = Category::with('subcategories')->where('supercategory_id', 0)->get();

        $categories = $rootCategories->map(function ($category) {
            $category->load('subcategories');
            $category = Category::addSubcategoriesRecursively($category);
            return $category;
        });

        return $categories;
    }

    protected static function addSubcategoriesRecursively($category)
    {
        if ($category->subcategories->isNotEmpty()) {
            $category->subcategories->transform(function ($subcategory) {
                $subcategory = Category::addSubcategoriesRecursively($subcategory);
                return $subcategory;
            });
        }

        return $category;
    }
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'supercategory_id');
    }

    public function supercategory()
    {
        return $this->belongsTo(Category::class, 'supercategory_id');
    }
}
