<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\UniqueGiftColors;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftColorsTest extends TestCase
{
    public function testBase(): void
    {
        $type = new UniqueGiftColors(
            'model-emoji-123',
            'symbol-emoji-456',
            0xFF5733,
            [0xC70039, 0x900C3F],
            0x581845,
            [0xFFC300, 0xDAF7A6, 0x33FF57],
        );

        assertSame('model-emoji-123', $type->modelCustomEmojiId);
        assertSame('symbol-emoji-456', $type->symbolCustomEmojiId);
        assertSame(0xFF5733, $type->lightThemeMainColor);
        assertSame([0xC70039, 0x900C3F], $type->lightThemeOtherColors);
        assertSame(0x581845, $type->darkThemeMainColor);
        assertSame([0xFFC300, 0xDAF7A6, 0x33FF57], $type->darkThemeOtherColors);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'model_custom_emoji_id' => 'model-emoji-abc',
            'symbol_custom_emoji_id' => 'symbol-emoji-def',
            'light_theme_main_color' => 16733525,
            'light_theme_other_colors' => [13041721, 9473087],
            'dark_theme_main_color' => 5773381,
            'dark_theme_other_colors' => [16761600, 14349222, 3407703],
        ], null, UniqueGiftColors::class);

        assertInstanceOf(UniqueGiftColors::class, $type);
        assertSame('model-emoji-abc', $type->modelCustomEmojiId);
        assertSame('symbol-emoji-def', $type->symbolCustomEmojiId);
        assertSame(16733525, $type->lightThemeMainColor);
        assertSame([13041721, 9473087], $type->lightThemeOtherColors);
        assertSame(5773381, $type->darkThemeMainColor);
        assertSame([16761600, 14349222, 3407703], $type->darkThemeOtherColors);
    }
}
