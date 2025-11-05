<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');

        assertSame(1, $chat->id);
        assertSame('private', $chat->type);
        assertNull($chat->title);
        assertNull($chat->username);
        assertNull($chat->firstName);
        assertNull($chat->lastName);
        assertNull($chat->isForum);
        assertNull($chat->isDirectMessages);
    }

    public function testFromTelegramResult(): void
    {
        $chat = (new ObjectFactory())->create([
            'id' => 1,
            'type' => 'private',
            'title' => 'Title',
            'username' => 'username',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'is_forum' => true,
            'is_direct_messages' => true,
        ], null, Chat::class);

        assertSame(1, $chat->id);
        assertSame('private', $chat->type);
        assertSame('Title', $chat->title);
        assertSame('username', $chat->username);
        assertSame('First Name', $chat->firstName);
        assertSame('Last Name', $chat->lastName);
        assertTrue($chat->isForum);
        assertTrue($chat->isDirectMessages);
    }
}
