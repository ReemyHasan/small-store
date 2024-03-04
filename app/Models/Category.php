<?php

namespace App\Models;

use App\Traits\CreatedFrom;
use App\Traits\ImageAttribute;
use Illuminate\Database\Eloquent\Builder;
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

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'supercategory_id')
        ->select([
            'id',
            'name',
            'supercategory_id',
            'created_at'
        ])->with(['subcategories', 'products.user']);;
    }

    public function supercategory()
    {
        return $this->belongsTo(Category::class, 'supercategory_id');
    }
    public function scopeParent(Builder $builder) {
        $builder->where('supercategory_id',0);
    }
}
