<?php

namespace Shared\Domain\ValueObjects;

use DateTime;

class Date
{
    private const DEFAULT_DATE_TIME_FORMAT = "c";

    public function __construct(private readonly DateTime $value)
    {}

    public static function current(): Date
    {
        return new static(new DateTime());
    }

    public function toString(string $format = self::DEFAULT_DATE_TIME_FORMAT): string
    {
        return $this->value()->format($format);
    }

    public function value(): DateTime
    {
        return $this->value;
    }
}