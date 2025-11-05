<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessMessagesDeleted;
use Phptg\BotApi\Type\Chat;

use function PHPUnit\Framework\assertSame;

final class BusinessMessagesDeletedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(97, 'private');
        $businessMessagesDeleted = new BusinessMessagesDeleted(
            'cid1',
            $chat,
            [1, 2, 3],
        );

        assertSame('cid1', $businessMessagesDeleted->businessConnectionId);
        assertSame($chat, $businessMessagesDeleted->chat);
        assertSame([1, 2, 3], $businessMessagesDeleted->messageIds);
    }

    public function testFromTelegramResult(): void
    {
        $businessMessagesDeleted = (new ObjectFactory())->create([
            'business_connection_id' => 'cid1',
            'chat' => [
                'id' => 97,
                'type' => 'private',
            ],
            'message_ids' => [1, 2, 3],
        ], null, BusinessMessagesDeleted::class);

        assertSame('cid1', $businessMessagesDeleted->businessConnectionId);
        assertSame(97, $businessMessagesDeleted->chat->id);
        assertSame([1, 2, 3], $businessMessagesDeleted->messageIds);
    }
}
