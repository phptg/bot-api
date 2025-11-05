<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\LocationAddress;
use Phptg\BotApi\Type\StoryAreaTypeLocation;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class StoryAreaTypeLocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new StoryAreaTypeLocation(
            latitude: 37.7749,
            longitude: -122.4194,
        );

        assertSame(37.7749, $location->latitude);
        assertSame(-122.4194, $location->longitude);
        assertNull($location->address);

        assertSame(
            [
                'type' => 'location',
                'latitude' => 37.7749,
                'longitude' => -122.4194,
            ],
            $location->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $address = new LocationAddress(
            countryCode: 'US',
            state: 'California',
            city: 'San Francisco',
            street: 'Market Street',
        );

        $location = new StoryAreaTypeLocation(
            latitude: 37.7749,
            longitude: -122.4194,
            address: $address,
        );

        assertSame(37.7749, $location->latitude);
        assertSame(-122.4194, $location->longitude);
        assertSame($address, $location->address);

        assertSame(
            [
                'type' => 'location',
                'latitude' => 37.7749,
                'longitude' => -122.4194,
                'address' => [
                    'country_code' => 'US',
                    'state' => 'California',
                    'city' => 'San Francisco',
                    'street' => 'Market Street',
                ],
            ],
            $location->toRequestArray(),
        );
    }
}
