<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Passport\PassportElementErrorUnspecified;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorUnspecifiedTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorUnspecified('driver_license', 'qwerty', 'Test message');

        assertSame('unspecified', $type->getSource());
        assertSame(
            [
                'source' => 'unspecified',
                'type' => 'driver_license',
                'element_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
