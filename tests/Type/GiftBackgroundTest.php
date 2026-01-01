<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GiftBackground;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GiftBackgroundTest extends TestCase
{
    public function testBase(): void
    {
        $type = new GiftBackground(
            0xFF5733,
            0xC70039,
            0xFFFFFF,
        );

        assertSame(0xFF5733, $type->centerColor);
        assertSame(0xC70039, $type->edgeColor);
        assertSame(0xFFFFFF, $type->textColor);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'center_color' => 16733525,
            'edge_color' => 13041721,
            'text_color' => 16777215,
        ], null, GiftBackground::class);

        assertInstanceOf(GiftBackground::class, $type);
        assertSame(16733525, $type->centerColor);
        assertSame(13041721, $type->edgeColor);
        assertSame(16777215, $type->textColor);
    }
}
