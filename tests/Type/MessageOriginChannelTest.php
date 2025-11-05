<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\MessageOriginChannel;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class MessageOriginChannelTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $chat = new Chat(1, 'private');
        $origin = new MessageOriginChannel($date, $chat, 12);

        assertSame('channel', $origin->getType());
        assertSame($date, $origin->getDate());
        assertSame($date, $origin->date);
        assertSame($chat, $origin->chat);
        assertSame(12, $origin->messageId);
        assertNull($origin->authorSignature);
    }

    public function testFromTelegramResult(): void
    {
        $origin = (new ObjectFactory())->create([
            'type' => 'channel',
            'date' => 12412512,
            'chat' => [
                'id' => 123,
                'type' => 'private',
            ],
            'message_id' => 12,
            'author_signature' => 'John Doe',
        ], null, MessageOriginChannel::class);

        assertSame('channel', $origin->getType());
        assertSame(12412512, $origin->getDate()->getTimestamp());
        assertSame(12412512, $origin->date->getTimestamp());
        assertSame(123, $origin->chat->id);
        assertSame(12, $origin->messageId);
        assertSame('John Doe', $origin->authorSignature);
    }
}
