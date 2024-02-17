<?php
namespace App\Traits;

use Illuminate\Http\Request;

trait CreatedFrom {
    public function getCreatedFromAttribute()
    {
        return str_ireplace(
            [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
            ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w'],
            $this->created_at->diffForHumans()
        );
    }
}
