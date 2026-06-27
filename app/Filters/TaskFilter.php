<?php

namespace App\Filters;

use App\Enums\TaskStatus;


class TaskFilter extends QueryFilter
{
    public function project_id(string $value) 
    {
        return $this->builder->where('project_id', $value);
    }

    public function team_id(string $value) 
    {
        return $this->builder->where('team_id', $value);
    }

    public function status(string $value) 
    {
        $value = TaskStatus::from($value);
        return $this->builder->where('status', $value);
    }
}
    