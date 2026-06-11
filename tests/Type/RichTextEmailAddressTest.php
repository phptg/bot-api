<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextEmailAddress;

use function PHPUnit\Framework\assertSame;

final class RichTextEmailAddressTest extends TestCase
{
    public function testBase(): void
    {
        $emailAddress = new RichTextEmailAddress('hello', 'test@example.com');

        assertSame('email_address', $emailAddress->getType());
        assertSame('hello', $emailAddress->text);
        assertSame('test@example.com', $emailAddress->emailAddress);
    }

    public function testFromTelegramResult(): void
    {
        $emailAddress = (new ObjectFactory())->create([
            'type' => 'email_address',
            'text' => 'hello',
            'email_address' => 'test@example.com',
        ], null, RichTextEmailAddress::class);

        assertSame('email_address', $emailAddress->getType());
        assertSame('hello', $emailAddress->text);
        assertSame('test@example.com', $emailAddress->emailAddress);
    }
}
