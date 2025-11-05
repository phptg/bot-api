<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BackgroundFillSolid;
use Phptg\BotApi\Type\BackgroundTypeFill;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class BackgroundTypeFillTest extends TestCase
{
    public function testBase(): void
    {
        $type = new BackgroundTypeFill(
            new BackgroundFillSolid(0x000000),
            95,
        );

        assertSame('fill', $type->getType());
        assertInstanceOf(BackgroundFillSolid::class, $type->fill);
        assertSame(0x000000, $type->fill->color);
        assertSame(95, $type->darkThemeDimming);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'fill',
            'fill' => [
                'type' => 'solid',
                'color' => 0x000000,
            ],
            'dark_theme_dimming' => 95,
        ], null, BackgroundTypeFill::class);

        assertSame('fill', $type->getType());
        assertInstanceOf(BackgroundFillSolid::class, $type->fill);
        assertSame(0x000000, $type->fill->color);
        assertSame(95, $type->darkThemeDimming);
    }
}
