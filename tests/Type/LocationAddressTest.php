<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\LocationAddress;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class LocationAddressTest extends TestCase
{
    public function testBase(): void
    {
        $locationAddress = new LocationAddress('RU');

        assertSame('RU', $locationAddress->countryCode);
        assertNull($locationAddress->state);
        assertNull($locationAddress->city);
        assertNull($locationAddress->street);

        assertSame(
            [
                'country_code' => 'RU',
            ],
            $locationAddress->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $locationAddress = new LocationAddress('US', 'California', 'Los Angeles', 'Sunset Boulevard');

        assertSame('US', $locationAddress->countryCode);
        assertSame('California', $locationAddress->state);
        assertSame('Los Angeles', $locationAddress->city);
        assertSame('Sunset Boulevard', $locationAddress->street);

        assertSame(
            [
                'country_code' => 'US',
                'state' => 'California',
                'city' => 'Los Angeles',
                'street' => 'Sunset Boulevard',
            ],
            $locationAddress->toRequestArray(),
        );
    }
}
