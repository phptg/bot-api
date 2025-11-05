<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Passport\PassportElementErrorDataField;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorDataFieldTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorDataField('driver_license', 'test.jpg', 'qwerty', 'Test message');

        assertSame('data', $type->getSource());
        assertSame(
            [
                'source' => 'data',
                'type' => 'driver_license',
                'field_name' => 'test.jpg',
                'data_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
