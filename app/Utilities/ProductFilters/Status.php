<?php

namespace App\Utilities\ProductFilters;

use App\Utilities\QueryFilter;
use App\Utilities\FilterContract;

class Status extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        // if($value == "Asc" || $value == "Desc")
        $this->query->where('is_accepted',$value);
    }
}
