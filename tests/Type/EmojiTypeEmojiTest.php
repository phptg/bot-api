<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\EmojiTypeEmoji;

use function PHPUnit\Framework\assertSame;

final class EmojiTypeEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $emojiType = new EmojiTypeEmoji('👍');

        assertSame('emoji', $emojiType->getType());
        assertSame('👍', $emojiType->emoji);
    }

    public function testFromTelegramResult(): void
    {
        $emojiType = (new ObjectFactory())->create([
            'type' => 'emoji',
            'emoji' => '👍',
        ], null, EmojiTypeEmoji::class);

        assertSame('emoji', $emojiType->getType());
        assertSame('👍', $emojiType->emoji);
    }
}
