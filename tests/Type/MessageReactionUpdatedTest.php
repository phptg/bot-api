<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\MessageReactionUpdated;
use Phptg\BotApi\Type\ReactionTypeCustomEmoji;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class MessageReactionUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $date = new DateTimeImmutable();
        $oldReaction = new ReactionTypeCustomEmoji('=)');
        $newReaction = new ReactionTypeCustomEmoji(';)');
        $messageReactionUpdated = new MessageReactionUpdated($chat, 99, $date, [$oldReaction], [$newReaction]);

        assertSame($chat, $messageReactionUpdated->chat);
        assertSame(99, $messageReactionUpdated->messageId);
        assertSame($date, $messageReactionUpdated->date);
        assertSame([$oldReaction], $messageReactionUpdated->oldReaction);
        assertSame([$newReaction], $messageReactionUpdated->newReaction);
    }

    public function testFromTelegramResult(): void
    {
        $messageReactionUpdated = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 99,
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'actor_chat' => [
                'id' => 2,
                'type' => 'private',
            ],
            'date' => 1623150080,
            'old_reaction' => [
                [
                    'type' => 'emoji',
                    'emoji' => '=)',
                ],
            ],
            'new_reaction' => [
                [
                    'type' => 'emoji',
                    'emoji' => ';)',
                ],
            ],
        ], null, MessageReactionUpdated::class);

        assertSame(1, $messageReactionUpdated->chat->id);
        assertSame(99, $messageReactionUpdated->messageId);
        assertSame(1623150080, $messageReactionUpdated->date->getTimestamp());
        assertSame('John', $messageReactionUpdated->user?->firstName);
        assertSame(2, $messageReactionUpdated->actorChat?->id);

        assertCount(1, $messageReactionUpdated->oldReaction);
        assertSame('=)', $messageReactionUpdated->oldReaction[0]->emoji);

        assertCount(1, $messageReactionUpdated->newReaction);
        assertSame(';)', $messageReactionUpdated->newReaction[0]->emoji);
    }
}
