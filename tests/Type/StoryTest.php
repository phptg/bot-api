<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Story;

use function PHPUnit\Framework\assertSame;

final class StoryTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $story = new Story($chat, 25);

        assertSame($chat, $story->chat);
        assertSame(25, $story->id);
    }

    public function testFromTelegramResult(): void
    {
        $story = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'id' => 25,
        ], null, Story::class);

        assertSame(1, $story->chat->id);
        assertSame(25, $story->id);
    }
}
