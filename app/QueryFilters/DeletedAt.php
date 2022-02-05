<?php

namespace App\QueryFilters;

use Closure;

class DeletedAt
{
    public function handle($query, Closure $next)
    {
        $builder = $next($query);

        if (! request()->has('onlyTrashed')) {
            return $builder;
        }

        if (request()->input('onlyTrashed') === 'false') {
            return $builder;
        }

        return $builder->onlyTrashed();
    }
}