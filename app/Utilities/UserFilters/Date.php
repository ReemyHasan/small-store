<?php

namespace App\Utilities\UserFilters;

use App\Utilities\QueryFilter;
use App\Utilities\FilterContract;

class Date extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->orderBy('created_at',$value);
    }
}
