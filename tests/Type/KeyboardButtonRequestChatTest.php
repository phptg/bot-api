<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\ChatAdministratorRights;
use Phptg\BotApi\Type\KeyboardButtonRequestChat;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class KeyboardButtonRequestChatTest extends TestCase
{
    public function testBase(): void
    {
        $keyboardButtonRequestChat = new KeyboardButtonRequestChat(1, true);

        assertSame(1, $keyboardButtonRequestChat->requestId);
        assertTrue($keyboardButtonRequestChat->chatIsChannel);
        assertNull($keyboardButtonRequestChat->chatIsForum);
        assertNull($keyboardButtonRequestChat->chatHasUsername);
        assertNull($keyboardButtonRequestChat->chatIsCreated);
        assertNull($keyboardButtonRequestChat->userAdministratorRights);
        assertNull($keyboardButtonRequestChat->botAdministratorRights);
        assertNull($keyboardButtonRequestChat->botIsMember);
        assertNull($keyboardButtonRequestChat->requestTitle);
        assertNull($keyboardButtonRequestChat->requestUsername);
        assertNull($keyboardButtonRequestChat->requestPhoto);

        assertSame(
            [
                'request_id' => 1,
                'chat_is_channel' => true,
            ],
            $keyboardButtonRequestChat->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $userAdministratorRights = new ChatAdministratorRights(
            true,
            false,
            true,
            true,
            true,
            false,
            true,
            false,
            true,
            true,
            true,
        );
        $botAdministratorRights = new ChatAdministratorRights(
            true,
            false,
            true,
            true,
            true,
            false,
            true,
            false,
            true,
            true,
            true,
        );
        $keyboardButtonRequestChat = new KeyboardButtonRequestChat(
            1,
            true,
            false,
            true,
            true,
            $userAdministratorRights,
            $botAdministratorRights,
            true,
            false,
            false,
            true,
        );

        assertSame(1, $keyboardButtonRequestChat->requestId);
        assertTrue($keyboardButtonRequestChat->chatIsChannel);
        assertFalse($keyboardButtonRequestChat->chatIsForum);
        assertTrue($keyboardButtonRequestChat->chatHasUsername);
        assertTrue($keyboardButtonRequestChat->chatIsCreated);
        assertSame($userAdministratorRights, $keyboardButtonRequestChat->userAdministratorRights);
        assertSame($botAdministratorRights, $keyboardButtonRequestChat->botAdministratorRights);
        assertTrue($keyboardButtonRequestChat->botIsMember);
        assertFalse($keyboardButtonRequestChat->requestTitle);
        assertFalse($keyboardButtonRequestChat->requestUsername);
        assertTrue($keyboardButtonRequestChat->requestPhoto);

        assertSame(
            [
                'request_id' => 1,
                'chat_is_channel' => true,
                'chat_is_forum' => false,
                'chat_has_username' => true,
                'chat_is_created' => true,
                'user_administrator_rights' => $userAdministratorRights->toRequestArray(),
                'bot_administrator_rights' => $botAdministratorRights->toRequestArray(),
                'bot_is_member' => true,
                'request_title' => false,
                'request_username' => false,
                'request_photo' => true,
            ],
            $keyboardButtonRequestChat->toRequestArray(),
        );
    }
}
