<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\MessageGenerationStopped;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class MessageGenerationStoppedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $update = new MessageGenerationStopped($chat, 100);

        assertSame($chat, $update->chat);
        assertSame(100, $update->draftId);
        assertNull($update->messageThreadId);
    }

    public function testFull(): void
    {
        $chat = new Chat(1, 'private');
        $update = new MessageGenerationStopped($chat, 100, 99);

        assertSame($chat, $update->chat);
        assertSame(100, $update->draftId);
        assertSame(99, $update->messageThreadId);
    }

    public function testFromTelegramResult(): void
    {
        $update = (new ObjectFactory())->create([
            'chat' => ['id' => 1, 'type' => 'private'],
            'draft_id' => 100,
        ], null, MessageGenerationStopped::class);

        assertInstanceOf(Chat::class, $update->chat);
        assertSame(1, $update->chat->id);
        assertSame(100, $update->draftId);
        assertNull($update->messageThreadId);
    }

    public function testFromTelegramResultFull(): void
    {
        $update = (new ObjectFactory())->create([
            'chat' => ['id' => 1, 'type' => 'private'],
            'message_thread_id' => 99,
            'draft_id' => 100,
        ], null, MessageGenerationStopped::class);

        assertInstanceOf(Chat::class, $update->chat);
        assertSame(1, $update->chat->id);
        assertSame(100, $update->draftId);
        assertSame(99, $update->messageThreadId);
    }
}
