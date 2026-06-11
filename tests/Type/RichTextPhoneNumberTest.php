<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextPhoneNumber;

use function PHPUnit\Framework\assertSame;

final class RichTextPhoneNumberTest extends TestCase
{
    public function testBase(): void
    {
        $phoneNumber = new RichTextPhoneNumber('hello', '+1234567890');

        assertSame('phone_number', $phoneNumber->getType());
        assertSame('hello', $phoneNumber->text);
        assertSame('+1234567890', $phoneNumber->phoneNumber);
    }

    public function testFromTelegramResult(): void
    {
        $phoneNumber = (new ObjectFactory())->create([
            'type' => 'phone_number',
            'text' => 'hello',
            'phone_number' => '+1234567890',
        ], null, RichTextPhoneNumber::class);

        assertSame('phone_number', $phoneNumber->getType());
        assertSame('hello', $phoneNumber->text);
        assertSame('+1234567890', $phoneNumber->phoneNumber);
    }
}
