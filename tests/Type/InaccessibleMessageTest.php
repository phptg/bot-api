<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\InaccessibleMessage;

use function PHPUnit\Framework\assertSame;

final class InaccessibleMessageTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $inaccessibleMessage = new InaccessibleMessage($chat, 23);

        assertSame($chat, $inaccessibleMessage->chat);
        assertSame(23, $inaccessibleMessage->messageId);
    }

    public function testFromTelegramResult(): void
    {
        $inaccessibleMessage = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 23,
        ], null, InaccessibleMessage::class);

        assertSame(1, $inaccessibleMessage->chat->id);
        assertSame(23, $inaccessibleMessage->messageId);
    }
}
