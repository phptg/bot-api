<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\KeyboardButton;
use Phptg\BotApi\Type\KeyboardButtonPollType;
use Phptg\BotApi\Type\KeyboardButtonRequestChat;
use Phptg\BotApi\Type\KeyboardButtonRequestUsers;
use Phptg\BotApi\Type\WebAppInfo;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class KeyboardButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new KeyboardButton('test');

        assertSame('test', $button->text);
        assertNull($button->requestUsers);
        assertNull($button->requestChat);
        assertNull($button->requestContact);
        assertNull($button->requestLocation);
        assertNull($button->requestPoll);
        assertNull($button->webApp);

        assertSame(
            [
                'text' => 'test',
            ],
            $button->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $requestUsers = new KeyboardButtonRequestUsers(1);
        $requestChat = new KeyboardButtonRequestChat(2, true);
        $requestPoll = new KeyboardButtonPollType('test');
        $webApp = new WebAppInfo('https://example.com/test');
        $button = new KeyboardButton(
            'test',
            $requestUsers,
            $requestChat,
            true,
            false,
            $requestPoll,
            $webApp,
        );

        assertSame('test', $button->text);
        assertSame($requestUsers, $button->requestUsers);
        assertSame($requestChat, $button->requestChat);
        assertTrue($button->requestContact);
        assertFalse($button->requestLocation);
        assertSame($requestPoll, $button->requestPoll);
        assertSame($webApp, $button->webApp);

        assertSame(
            [
                'text' => 'test',
                'request_users' => $requestUsers->toRequestArray(),
                'request_chat' => $requestChat->toRequestArray(),
                'request_contact' => true,
                'request_location' => false,
                'request_poll' => $requestPoll->toRequestArray(),
                'web_app' => $webApp->toRequestArray(),
            ],
            $button->toRequestArray(),
        );
    }
}
