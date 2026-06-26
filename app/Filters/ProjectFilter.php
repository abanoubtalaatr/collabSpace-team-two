<?php

namespace App\Filters;

class ProjectFilter extends QueryFilter
{
    public function status($status)
    {
        $this->builder->where('status', $status);
    }

    public function name($name)
    {
        $this->builder->where('name', 'like', "%$name%");
    }

    public function created_at($created_at)
    {
        $this->builder->whereDate('created_at', $created_at);
    }
}
