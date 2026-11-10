<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatShareThemeBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatShareThemeBackdropTest extends TestCase
{
    public function testBase(): void
    {
        $chatShareThemeBackdrop = new ChatShareThemeBackdrop(
            1,
            'Pattern',
            new UniqueGiftBackdropColors(0xFFFFFF, 0x000000, 0xFF0000, 0x00FF00),
        );

        assertSame(1, $chatShareThemeBackdrop->id);
        assertSame('Pattern', $chatShareThemeBackdrop->name);
        assertSame(0xFFFFFF, $chatShareThemeBackdrop->colors->centerColor);
    }

    public function testFromTelegramResult(): void
    {
        $chatShareThemeBackdrop = (new ObjectFactory())->create([
            'id' => 1,
            'name' => 'Pattern',
            'colors' => [
                'center_color' => 0xFFFFFF,
                'edge_color' => 0x000000,
                'symbol_color' => 0xFF0000,
                'text_color' => 0x00FF00,
            ],
        ], null, ChatShareThemeBackdrop::class);

        assertInstanceOf(ChatShareThemeBackdrop::class, $chatShareThemeBackdrop);
        assertSame(1, $chatShareThemeBackdrop->id);
        assertSame('Pattern', $chatShareThemeBackdrop->name);
        assertSame(0xFFFFFF, $chatShareThemeBackdrop->colors->centerColor);
        assertSame(0x000000, $chatShareThemeBackdrop->colors->edgeColor);
    }
}
