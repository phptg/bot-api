<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BackgroundFillSolid;

use function PHPUnit\Framework\assertSame;

final class BackgroundFillSolidTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillSolid(0x000000);

        assertSame('solid', $fill->getType());
        assertSame(0x000000, $fill->color);
    }

    public function testFromTelegramResult(): void
    {
        $fill = (new ObjectFactory())->create([
            'type' => 'solid',
            'color' => 0x000000,
        ], null, BackgroundFillSolid::class);

        assertSame('solid', $fill->getType());
        assertSame(0x000000, $fill->color);
    }
}
