<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ForumTopic;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $type = new ForumTopic(1, 'test', 0x00FF00);

        assertSame(1, $type->messageThreadId);
        assertSame('test', $type->name);
        assertSame(0x00FF00, $type->iconColor);
        assertNull($type->iconCustomEmojiId);
        assertNull($type->isNameImplicit);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'message_thread_id' => 1,
            'name' => 'test',
            'icon_color' => 0x00FF00,
            'icon_custom_emoji_id' => '2351346235143',
            'is_name_implicit' => true,
        ], null, ForumTopic::class);

        assertSame(1, $type->messageThreadId);
        assertSame('test', $type->name);
        assertSame(0x00FF00, $type->iconColor);
        assertSame('2351346235143', $type->iconCustomEmojiId);
        assertSame(true, $type->isNameImplicit);
    }
}
