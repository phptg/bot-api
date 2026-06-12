<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextCustomEmoji;

use function PHPUnit\Framework\assertSame;

final class RichTextCustomEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $customEmoji = new RichTextCustomEmoji('emoji123', '😀');

        assertSame('custom_emoji', $customEmoji->getType());
        assertSame('emoji123', $customEmoji->customEmojiId);
        assertSame('😀', $customEmoji->alternativeText);
    }

    public function testFromTelegramResult(): void
    {
        $customEmoji = (new ObjectFactory())->create([
            'type' => 'custom_emoji',
            'custom_emoji_id' => 'emoji123',
            'alternative_text' => '😀',
        ], null, RichTextCustomEmoji::class);

        assertSame('custom_emoji', $customEmoji->getType());
        assertSame('emoji123', $customEmoji->customEmojiId);
        assertSame('😀', $customEmoji->alternativeText);
    }
}
