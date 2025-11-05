<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Contact;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ContactTest extends TestCase
{
    public function testBase(): void
    {
        $contact = new Contact('+3123456', 'Mike');

        assertSame('+3123456', $contact->phoneNumber);
        assertSame('Mike', $contact->firstName);
        assertNull($contact->lastName);
        assertNull($contact->userId);
        assertNull($contact->vcard);
    }

    public function testFromTelegramResult(): void
    {
        $contact = (new ObjectFactory())->create([
            'phone_number' => '+3123456',
            'first_name' => 'Mike',
            'last_name' => 'Smith',
            'user_id' => 123,
            'vcard' => 'vcard',
        ], null, Contact::class);

        assertSame('+3123456', $contact->phoneNumber);
        assertSame('Mike', $contact->firstName);
        assertSame('Smith', $contact->lastName);
        assertSame(123, $contact->userId);
        assertSame('vcard', $contact->vcard);
    }
}
