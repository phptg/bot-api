<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\KeyboardButtonRequestManagedBot;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class KeyboardButtonRequestManagedBotTest extends TestCase
{
    public function testBase(): void
    {
        $keyboardButtonRequestManagedBot = new KeyboardButtonRequestManagedBot(1);

        assertSame(1, $keyboardButtonRequestManagedBot->requestId);
        assertNull($keyboardButtonRequestManagedBot->suggestedName);
        assertNull($keyboardButtonRequestManagedBot->suggestedUsername);

        assertSame(
            [
                'request_id' => 1,
            ],
            $keyboardButtonRequestManagedBot->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $keyboardButtonRequestManagedBot = new KeyboardButtonRequestManagedBot(
            1,
            'My Bot',
            'my_bot',
        );

        assertSame(1, $keyboardButtonRequestManagedBot->requestId);
        assertSame('My Bot', $keyboardButtonRequestManagedBot->suggestedName);
        assertSame('my_bot', $keyboardButtonRequestManagedBot->suggestedUsername);

        assertSame(
            [
                'request_id' => 1,
                'suggested_name' => 'My Bot',
                'suggested_username' => 'my_bot',
            ],
            $keyboardButtonRequestManagedBot->toRequestArray(),
        );
    }
}
