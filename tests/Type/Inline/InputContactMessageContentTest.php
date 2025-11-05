<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InputContactMessageContent;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputContactMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputContactMessageContent('+70001234567', 'John');

        assertSame('+70001234567', $type->phoneNumber);
        assertSame('John', $type->firstName);
        assertNull($type->lastName);
        assertNull($type->vcard);

        assertSame(
            [
                'phone_number' => '+70001234567',
                'first_name' => 'John',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $type = new InputContactMessageContent('+70001234567', 'John', 'Doe', 'vcard!');

        assertSame('+70001234567', $type->phoneNumber);
        assertSame('John', $type->firstName);
        assertSame('Doe', $type->lastName);
        assertSame('vcard!', $type->vcard);

        assertSame(
            [
                'phone_number' => '+70001234567',
                'first_name' => 'John',
                'last_name' => 'Doe',
                'vcard' => 'vcard!',
            ],
            $type->toRequestArray(),
        );
    }
}
