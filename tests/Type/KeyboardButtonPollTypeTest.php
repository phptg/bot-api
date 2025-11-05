<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\KeyboardButtonPollType;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class KeyboardButtonPollTypeTest extends TestCase
{
    public function testBase(): void
    {
        $keyboardButtonPollType = new KeyboardButtonPollType();

        assertNull($keyboardButtonPollType->type);

        assertSame([], $keyboardButtonPollType->toRequestArray());
    }

    public function testFilled(): void
    {
        $keyboardButtonPollType = new KeyboardButtonPollType('test');

        assertSame('test', $keyboardButtonPollType->type);

        assertSame(
            [
                'type' => 'test',
            ],
            $keyboardButtonPollType->toRequestArray(),
        );
    }
}
