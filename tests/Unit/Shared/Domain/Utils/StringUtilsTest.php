<?php

namespace Tests\Unit\Shared\Domain\Utils;

use PHPUnit\Framework\TestCase;
use Shared\Domain\Utils\StringUtils;

class StringUtilsTest extends TestCase
{
    /** @test */
    public function string_should_be_created_with_correct_size(): void
    {
        $size = 10;
        $string = StringUtils::random($size);

        self::assertEquals($size, strlen($string));
    }
}
