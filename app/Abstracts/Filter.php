<?php

namespace App\Abstracts;

use Closure;
use Illuminate\Support\Str;

abstract class Filter
{
    public function handle($query, Closure $next)
    {
        $builder = $next($query);
        
        if (! request()->has($this->getFieldToFilter())) {
            return $builder;
        }

        return $this->applyFilter($builder);
    }

    public function getFieldToFilter(): string
    {
        return Str::of(class_basename($this))
            ->snake()
            ->lower();
    }

    public abstract function applyFilter($builder);
}