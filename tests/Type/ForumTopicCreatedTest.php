<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ForumTopicCreated;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ForumTopicCreatedTest extends TestCase
{
    public function testBase(): void
    {
        $forumTopicCreated = new ForumTopicCreated('test', 0x123456);

        assertSame('test', $forumTopicCreated->name);
        assertSame(0x123456, $forumTopicCreated->iconColor);
        assertNull($forumTopicCreated->iconCustomEmojiId);
    }

    public function testFromTelegramResult(): void
    {
        $forumTopicCreated = (new ObjectFactory())->create([
            'name' => 'test',
            'icon_color' => 0x123456,
            'icon_custom_emoji_id' => 'x1',
        ], null, ForumTopicCreated::class);

        assertSame('test', $forumTopicCreated->name);
        assertSame(0x123456, $forumTopicCreated->iconColor);
        assertSame('x1', $forumTopicCreated->iconCustomEmojiId);
    }
}
