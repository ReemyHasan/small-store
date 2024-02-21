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
        "products"
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

}
