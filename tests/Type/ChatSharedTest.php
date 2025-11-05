<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatShared;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChatSharedTest extends TestCase
{
    public function testBase(): void
    {
        $chatShared = new ChatShared(12, 89);

        assertSame(12, $chatShared->requestId);
        assertSame(89, $chatShared->chatId);
        assertNull($chatShared->title);
        assertNull($chatShared->username);
        assertNull($chatShared->photo);
    }

    public function testFromTelegramResult(): void
    {
        $chatShared = (new ObjectFactory())->create([
            'request_id' => 12,
            'chat_id' => 89,
            'title' => 'Title',
            'username' => 'Vjik',
            'photo' => [
                ['file_id' => 'file_id1', 'file_unique_id' => 'file_unique_id1', 'width' => 1, 'height' => 2],
                ['file_id' => 'file_id2', 'file_unique_id' => 'file_unique_id2', 'width' => 3, 'height' => 4],
            ],
        ], null, ChatShared::class);

        assertSame(12, $chatShared->requestId);
        assertSame(89, $chatShared->chatId);
        assertSame('Title', $chatShared->title);
        assertSame('Vjik', $chatShared->username);

        assertCount(2, $chatShared->photo);
        assertSame('file_id1', $chatShared->photo[0]->fileId);
        assertSame('file_id2', $chatShared->photo[1]->fileId);
    }
}
