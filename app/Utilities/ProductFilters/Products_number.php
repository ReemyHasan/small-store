<?php

namespace App\Utilities\ProductFilters;

use App\Utilities\QueryFilter;
use App\Utilities\FilterContract;
use Illuminate\Support\Facades\DB;

class Products_number extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->select('products.*')
        ->selectSub(function ($query) {
            $query->select(DB::raw('COUNT(*)'))
                ->from('products as p')
                ->whereColumn('p.category_id', 'products.category_id')
                ->groupBy('p.category_id')
                ->limit(1);
        }, 'category_count')
        ->orderBy('category_count', $value);
    }
}
