<?php

namespace App\Models;

use App\Traits\CreatedFrom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes, CreatedFrom;
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];
    protected $with = [
        "category",
        "user"
    ];
    protected $appends = array("created_from","image_url");
    public function category(){
        return $this->belongsTo(Category::class,"category_id");
    }
    public function user(){
        return $this->belongsTo(User::class,"vendor_id");
    }
    public static function getRecords(){
        return self::orderBy("created_at","desc")->get();
    }
    public static function getRecord($id){
        return self::where("id",$id)->first();
    }
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('storage/' . $this->image);
        }
    }
}
