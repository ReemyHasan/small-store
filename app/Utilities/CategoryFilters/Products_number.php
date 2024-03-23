<?php

namespace App\Utilities\CategoryFilters;

use App\Utilities\QueryFilter;
use App\Utilities\FilterContract;

class Products_number extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->withCount('products')->orderBy('products_count',$value);

    }
}
