<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Location;
use Phptg\BotApi\Type\Venue;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class VenueTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.1, 2.2);
        $venue = new Venue($location, 'Title', 'Address');

        assertSame($location, $venue->location);
        assertSame('Title', $venue->title);
        assertSame('Address', $venue->address);
        assertNull($venue->foursquareId);
        assertNull($venue->foursquareType);
        assertNull($venue->googlePlaceId);
        assertNull($venue->googlePlaceType);
    }

    public function testFromTelegramResult(): void
    {
        $venue = (new ObjectFactory())->create([
            'location' => [
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            'title' => 'Title',
            'address' => 'Address',
            'foursquare_id' => 'FoursquareId',
            'foursquare_type' => 'FoursquareType',
            'google_place_id' => 'GooglePlaceId',
            'google_place_type' => 'GooglePlaceType',
        ], null, Venue::class);

        assertSame(1.1, $venue->location->latitude);
        assertSame(2.2, $venue->location->longitude);

        assertSame('Title', $venue->title);
        assertSame('Address', $venue->address);
        assertSame('FoursquareId', $venue->foursquareId);
        assertSame('FoursquareType', $venue->foursquareType);
        assertSame('GooglePlaceId', $venue->googlePlaceId);
        assertSame('GooglePlaceType', $venue->googlePlaceType);
    }
}
