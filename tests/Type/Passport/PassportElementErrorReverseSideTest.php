<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Passport;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Passport\PassportElementErrorReverseSide;

use function PHPUnit\Framework\assertSame;

final class PassportElementErrorReverseSideTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PassportElementErrorReverseSide('driver_license', 'qwerty', 'Test message');

        assertSame('reverse_side', $type->getSource());
        assertSame(
            [
                'source' => 'reverse_side',
                'type' => 'driver_license',
                'file_hash' => 'qwerty',
                'message' => 'Test message',
            ],
            $type->toRequestArray(),
        );
    }
}
