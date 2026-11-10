<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatShareThemeEmoji;
use Phptg\BotApi\Type\EmojiTypeCustomEmoji;
use Phptg\BotApi\Type\EmojiTypeEmoji;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChatShareThemeEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $chatShareTheme = new ChatShareThemeEmoji([
            new EmojiTypeEmoji('🎁'),
        ]);

        assertSame('emoji', $chatShareTheme->getType());
        assertCount(1, $chatShareTheme->emojis);
        assertNull($chatShareTheme->backgroundBackdropId);
    }

    public function testFull(): void
    {
        $emojis = [
            new EmojiTypeEmoji('🎁'),
            new EmojiTypeCustomEmoji('5368324170671202287'),
        ];
        $chatShareTheme = new ChatShareThemeEmoji($emojis, 123);

        assertSame('emoji', $chatShareTheme->getType());
        assertSame($emojis, $chatShareTheme->emojis);
        assertSame(123, $chatShareTheme->backgroundBackdropId);
    }

    public function testFromTelegramResult(): void
    {
        $chatShareTheme = (new ObjectFactory())->create([
            'type' => 'emoji',
            'emojis' => [
                ['type' => 'emoji', 'emoji' => '🎁'],
            ],
        ], null, ChatShareThemeEmoji::class);

        assertInstanceOf(ChatShareThemeEmoji::class, $chatShareTheme);
        assertInstanceOf(EmojiTypeEmoji::class, $chatShareTheme->emojis[0]);
        assertSame('🎁', $chatShareTheme->emojis[0]->emoji);
        assertNull($chatShareTheme->backgroundBackdropId);
    }

    public function testFromTelegramResultFull(): void
    {
        $chatShareTheme = (new ObjectFactory())->create([
            'type' => 'emoji',
            'emojis' => [
                ['type' => 'emoji', 'emoji' => '🎁'],
                ['type' => 'custom_emoji', 'custom_emoji_id' => '5368324170671202287'],
            ],
            'background_backdrop_id' => 123,
        ], null, ChatShareThemeEmoji::class);

        assertInstanceOf(ChatShareThemeEmoji::class, $chatShareTheme);
        assertInstanceOf(EmojiTypeEmoji::class, $chatShareTheme->emojis[0]);
        assertSame('🎁', $chatShareTheme->emojis[0]->emoji);
        assertInstanceOf(EmojiTypeCustomEmoji::class, $chatShareTheme->emojis[1]);
        assertSame('5368324170671202287', $chatShareTheme->emojis[1]->customEmojiId);
        assertSame(123, $chatShareTheme->backgroundBackdropId);
    }
}
