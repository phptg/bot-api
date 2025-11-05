<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftBackdropColorsTest extends TestCase
{
    public function testBase(): void
    {
        $colors = new UniqueGiftBackdropColors(1, 2, 3, 4);

        assertSame(1, $colors->centerColor);
        assertSame(2, $colors->edgeColor);
        assertSame(3, $colors->symbolColor);
        assertSame(4, $colors->textColor);
    }

    public function testFromTelegramResult(): void
    {
        $colors = (new ObjectFactory())->create([
            'center_color' => 1,
            'edge_color' => 2,
            'symbol_color' => 3,
            'text_color' => 4,
        ], null, UniqueGiftBackdropColors::class);

        assertInstanceOf(UniqueGiftBackdropColors::class, $colors);
        assertSame(1, $colors->centerColor);
        assertSame(2, $colors->edgeColor);
        assertSame(3, $colors->symbolColor);
        assertSame(4, $colors->textColor);
    }
}
