<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Birthdate;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class BirthdateTest extends TestCase
{
    public function testBase(): void
    {
        $birthdate = new Birthdate(27, 1);

        assertSame(27, $birthdate->day);
        assertSame(1, $birthdate->month);
        assertNull($birthdate->year);
    }

    public function testFromTelegramResult(): void
    {
        $birthdate = (new ObjectFactory())->create([
            'day' => 27,
            'month' => 1,
            'year' => 1986,
        ], null, Birthdate::class);

        assertSame(27, $birthdate->day);
        assertSame(1, $birthdate->month);
        assertSame(1986, $birthdate->year);
    }

}
