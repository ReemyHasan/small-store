<?php

namespace App\Models;

use App\Traits\CreatedFrom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, CreatedFrom;
    protected $guarded = [
        "id",
        "created_at",
        "updated_at",
    ];
    protected $appends = array("created_from");
    public function user(){
        return $this->belongsTo(User::class,'created_by');
    }
    static public function getRecords()
    {
        return self::orderBy("created_at","desc")->get();
    }
    static public function getRecord($id)
    {
        return self::where("id","=", $id)->first();
    }
}
