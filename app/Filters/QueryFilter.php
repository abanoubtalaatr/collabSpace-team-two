<?php

namespace App\Filters;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected Builder $builder; 
    /**
     * Create a new class instance.
     */
    public function __construct(protected Request $request){}

    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder; 

        foreach ($this->filterableParameters() as $name => $value) {
            if (method_exists($this, $name)) {
                $this->$name($value); 
            }
        }

        return $this->builder;
    }

    protected function filterableParameters(): array
    {
        return collect($this->request->all())->filter(fn (string $key) => method_exists($this, $key))
            ->mapWithKeys(fn (string $key) => [ $key=> $this->request->input($key) ])
            ->all(); 
    }
}
