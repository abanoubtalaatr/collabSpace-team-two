<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

trait Filterable
{
    public function scopeFilter(Builder $query, Request $request): Builder
    {
        $filterClass = self::resolveFilterClass(); 

        if (!class_exists($filterClass)) {
            return $query; 
        }

        $filter = new $filterClass($request); 

        return $query; 
    }


    public static function resolveFilterClass(): string 
    {
        return 'App\\Filters\\' . class_basename(static::class) . 'Filter';
    }
}
