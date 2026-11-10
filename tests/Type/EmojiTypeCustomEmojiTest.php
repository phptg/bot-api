<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\EmojiTypeCustomEmoji;

use function PHPUnit\Framework\assertSame;

final class EmojiTypeCustomEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $emojiType = new EmojiTypeCustomEmoji('5368324170671202286');

        assertSame('custom_emoji', $emojiType->getType());
        assertSame('5368324170671202286', $emojiType->customEmojiId);
    }

    public function testFromTelegramResult(): void
    {
        $emojiType = (new ObjectFactory())->create([
            'type' => 'custom_emoji',
            'custom_emoji_id' => '5368324170671202286',
        ], null, EmojiTypeCustomEmoji::class);

        assertSame('custom_emoji', $emojiType->getType());
        assertSame('5368324170671202286', $emojiType->customEmojiId);
    }
}
