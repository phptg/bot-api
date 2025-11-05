<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\MessageReactionCountUpdated;
use Phptg\BotApi\Type\ReactionCount;
use Phptg\BotApi\Type\ReactionTypeCustomEmoji;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class MessageReactionCountUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $reactionCount = new ReactionCount(new ReactionTypeCustomEmoji('=)'), 1);
        $date = new DateTimeImmutable();
        $messageReactionCountUpdated = new MessageReactionCountUpdated($chat, 99, $date, [$reactionCount]);

        assertSame($chat, $messageReactionCountUpdated->chat);
        assertSame(99, $messageReactionCountUpdated->messageId);
        assertSame($date, $messageReactionCountUpdated->date);
        assertSame([$reactionCount], $messageReactionCountUpdated->reactions);
    }

    public function testFromTelegramResult(): void
    {
        $messageReactionCountUpdated = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 99,
            'date' => 1623150080,
            'reactions' => [
                [
                    'type' => [
                        'type' => 'emoji',
                        'emoji' => '🤯',
                    ],
                    'total_count' => 2,
                ],
            ],
        ], null, MessageReactionCountUpdated::class);

        assertSame(1, $messageReactionCountUpdated->chat->id);
        assertSame(99, $messageReactionCountUpdated->messageId);
        assertSame(1623150080, $messageReactionCountUpdated->date->getTimestamp());

        assertCount(1, $messageReactionCountUpdated->reactions);
        assertSame('🤯', $messageReactionCountUpdated->reactions[0]->type->emoji);
    }
}
