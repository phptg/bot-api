<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PreparedKeyboardButton;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PreparedKeyboardButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new PreparedKeyboardButton('button_123');

        assertSame('button_123', $button->id);
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'id' => 'button_456',
        ], null, PreparedKeyboardButton::class);

        assertInstanceOf(PreparedKeyboardButton::class, $button);
        assertSame('button_456', $button->id);
    }
}
