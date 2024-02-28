<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $hidden = [
        'image'
    ];
    public static function getRecords()
    {
        return self::orderBy("created_at", "desc")->get();

    }
    public static function getRecord($id)
    {
        return self::where("id", $id)->first();
    }
}
