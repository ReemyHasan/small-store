<?php

namespace App\Utilities\ProductFilters;

use App\Utilities\QueryFilter;
use App\Utilities\FilterContract;

class Category extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->with('category')
        ->orderBy(\App\Models\Category::select('name')->whereColumn('categories.id','products.category_id'),$value);
    }
}
