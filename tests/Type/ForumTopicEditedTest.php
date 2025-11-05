<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ForumTopicEdited;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ForumTopicEditedTest extends TestCase
{
    public function testBase(): void
    {
        $forumTopicEdited = new ForumTopicEdited();

        assertNull($forumTopicEdited->name);
        assertNull($forumTopicEdited->iconCustomEmojiId);
    }

    public function testFromTelegramResult(): void
    {
        $forumTopicEdited = (new ObjectFactory())->create([
            'name' => 'test',
            'icon_custom_emoji_id' => 'x1',
        ], null, ForumTopicEdited::class);

        assertSame('test', $forumTopicEdited->name);
        assertSame('x1', $forumTopicEdited->iconCustomEmojiId);
    }
}
