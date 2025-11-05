<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\KeyboardButtonRequestUsers;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class KeyboardButtonRequestUsersTest extends TestCase
{
    public function testBase(): void
    {
        $keyboardButtonRequestUsers = new KeyboardButtonRequestUsers(1);

        assertSame(1, $keyboardButtonRequestUsers->requestId);
        assertNull($keyboardButtonRequestUsers->userIsBot);
        assertNull($keyboardButtonRequestUsers->userIsPremium);
        assertNull($keyboardButtonRequestUsers->maxQuantity);
        assertNull($keyboardButtonRequestUsers->requestName);
        assertNull($keyboardButtonRequestUsers->requestUsername);
        assertNull($keyboardButtonRequestUsers->requestPhoto);

        assertSame(
            [
                'request_id' => 1,
            ],
            $keyboardButtonRequestUsers->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $keyboardButtonRequestUsers = new KeyboardButtonRequestUsers(
            1,
            true,
            false,
            5,
            true,
            true,
            false,
        );

        assertSame(1, $keyboardButtonRequestUsers->requestId);
        assertTrue($keyboardButtonRequestUsers->userIsBot);
        assertFalse($keyboardButtonRequestUsers->userIsPremium);
        assertSame(5, $keyboardButtonRequestUsers->maxQuantity);
        assertTrue($keyboardButtonRequestUsers->requestName);
        assertTrue($keyboardButtonRequestUsers->requestUsername);
        assertFalse($keyboardButtonRequestUsers->requestPhoto);

        assertSame(
            [
                'request_id' => 1,
                'user_is_bot' => true,
                'user_is_premium' => false,
                'max_quantity' => 5,
                'request_name' => true,
                'request_username' => true,
                'request_photo' => false,
            ],
            $keyboardButtonRequestUsers->toRequestArray(),
        );
    }
}
