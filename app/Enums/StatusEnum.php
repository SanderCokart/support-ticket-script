<?php

namespace App\Enums;

enum StatusEnum: int
{
    case PENDING = 1;
    case IN_PROGRESS = 2;
    case RESOLVED = 3;

    public static function random(): self
    {
        return match (rand(1, 3)) {
            1 => self::PENDING,
            2 => self::IN_PROGRESS,
            3 => self::RESOLVED,
        };
    }

    public function getId(): int
    {
        return $this->value;
    }
}
