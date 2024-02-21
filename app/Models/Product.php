<?php

namespace App\Models;

use App\Traits\CreatedFrom;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Product extends BaseModel
{
    use HasFactory, CreatedFrom;
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];
    protected $appends = array("created_from", "image_url");
    public function category()
    {
        return $this->belongsTo(Category::class, "category_id");
    }
    public function user()
    {
        return $this->belongsTo(User::class, "vendor_id");
    }
    public function getImageUrlAttribute()
    {
        if ($this->images) {
            $urls =[];
            foreach($this->images as $image){
                array_push($urls,url('storage/' .$image->url));
            }
            return $urls;
        }
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('price', function (Builder $builder) {
            $builder->where('price', '>', 150);
        });
    }

    public function scopeFilter($query){
        return $query->with(['user' => function ($query) {
            $query->where('name', 'like', '%a%');
        }]);
    }
}
