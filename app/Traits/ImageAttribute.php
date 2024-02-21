<?php
namespace App\Traits;


trait ImageAttribute {
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return url('storage/' . $this->image->url);
        }
    }

}
