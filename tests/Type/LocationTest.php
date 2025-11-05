<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Location;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class LocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.234, 5.678);

        assertSame(1.234, $location->latitude);
        assertSame(5.678, $location->longitude);
        assertNull($location->horizontalAccuracy);
        assertNull($location->livePeriod);
        assertNull($location->heading);
        assertNull($location->proximityAlertRadius);
    }

    public function testFromTelegramResult(): void
    {
        $location = (new ObjectFactory())->create([
            'latitude' => 1.234,
            'longitude' => 5.678,
            'horizontal_accuracy' => 0.1,
            'live_period' => 60,
            'heading' => 90,
            'proximity_alert_radius' => 100,
        ], null, Location::class);

        assertSame(1.234, $location->latitude);
        assertSame(5.678, $location->longitude);
        assertSame(0.1, $location->horizontalAccuracy);
        assertSame(60, $location->livePeriod);
        assertSame(90, $location->heading);
        assertSame(100, $location->proximityAlertRadius);
    }
}
