<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatShareThemeBackdrop;
use Phptg\BotApi\Type\ChatShareThemeBackdrops;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatShareThemeBackdropsTest extends TestCase
{
    public function testBase(): void
    {
        $chatShareThemeBackdrops = new ChatShareThemeBackdrops([
            new ChatShareThemeBackdrop(1, 'Pattern', new UniqueGiftBackdropColors(0xFFFFFF, 0x000000, 0xFF0000, 0x00FF00)),
        ]);

        assertCount(1, $chatShareThemeBackdrops->backdrops);
        assertSame(1, $chatShareThemeBackdrops->backdrops[0]->id);
        assertSame('Pattern', $chatShareThemeBackdrops->backdrops[0]->name);
    }

    public function testFromTelegramResult(): void
    {
        $chatShareThemeBackdrops = (new ObjectFactory())->create([
            'backdrops' => [
                [
                    'id' => 1,
                    'name' => 'Pattern',
                    'colors' => [
                        'center_color' => 0xFFFFFF,
                        'edge_color' => 0x000000,
                        'symbol_color' => 0xFF0000,
                        'text_color' => 0x00FF00,
                    ],
                ],
            ],
        ], null, ChatShareThemeBackdrops::class);

        assertInstanceOf(ChatShareThemeBackdrops::class, $chatShareThemeBackdrops);
        assertCount(1, $chatShareThemeBackdrops->backdrops);
        assertInstanceOf(ChatShareThemeBackdrop::class, $chatShareThemeBackdrops->backdrops[0]);
        assertSame(1, $chatShareThemeBackdrops->backdrops[0]->id);
        assertSame('Pattern', $chatShareThemeBackdrops->backdrops[0]->name);
        assertSame(0xFFFFFF, $chatShareThemeBackdrops->backdrops[0]->colors->centerColor);
    }
}
