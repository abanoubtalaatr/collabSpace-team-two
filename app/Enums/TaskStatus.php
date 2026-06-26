<?php

namespace App\Enums;

enum TaskStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case IN_REVIEW = 'in_review';
    case COMPLETED = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::PENDING => 'Pending',
            self::IN_PROGRESS => 'In Progress',
            self::IN_REVIEW => 'In Review',
            self::COMPLETED => 'Completed',
        };
    }

    public static function values(): array 
    {
        return array_map(fn(TaskStatus $status) => $status->value, self::cases());
    }
}
