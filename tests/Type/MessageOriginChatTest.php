<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\MessageOriginChat;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class MessageOriginChatTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $chat = new Chat(1, 'private');
        $origin = new MessageOriginChat($date, $chat);

        assertSame('chat', $origin->getType());
        assertSame($date, $origin->getDate());
        assertSame($date, $origin->date);
        assertSame($chat, $origin->senderChat);
        assertNull($origin->authorSignature);
    }

    public function testFromTelegramResult(): void
    {
        $origin = (new ObjectFactory())->create([
            'type' => 'chat',
            'date' => 12412512,
            'sender_chat' => [
                'id' => 123,
                'type' => 'private',
            ],
            'author_signature' => 'John Doe',
        ], null, MessageOriginChat::class);

        assertSame('chat', $origin->getType());
        assertSame(12412512, $origin->getDate()->getTimestamp());
        assertSame(12412512, $origin->date->getTimestamp());
        assertSame(123, $origin->senderChat->id);
        assertSame('John Doe', $origin->authorSignature);
    }
}
