<?php

namespace App\QueryFilters;

use App\Abstracts\Filter;

class Name extends Filter
{
    public function applyFilter($builder)
    {
        return $builder->where('name', request()->input('name'));
    }
}