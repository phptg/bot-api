<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InputVenueMessageContent;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputVenueMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputVenueMessageContent(1.1, 2.2, 'Title', 'Address');

        assertSame(1.1, $type->latitude);
        assertSame(2.2, $type->longitude);
        assertSame('Title', $type->title);
        assertSame('Address', $type->address);
        assertNull($type->foursquareId);
        assertNull($type->foursquareType);
        assertNull($type->googlePlaceId);
        assertNull($type->googlePlaceType);
        assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Title',
                'address' => 'Address',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $type = new InputVenueMessageContent(1.1, 2.2, 'Title', 'Address', 'fid', 'ftype', 'gid', 'gtype');

        assertSame(1.1, $type->latitude);
        assertSame(2.2, $type->longitude);
        assertSame('Title', $type->title);
        assertSame('Address', $type->address);
        assertSame('fid', $type->foursquareId);
        assertSame('ftype', $type->foursquareType);
        assertSame('gid', $type->googlePlaceId);
        assertSame('gtype', $type->googlePlaceType);
        assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
                'title' => 'Title',
                'address' => 'Address',
                'foursquare_id' => 'fid',
                'foursquare_type' => 'ftype',
                'google_place_id' => 'gid',
                'google_place_type' => 'gtype',
            ],
            $type->toRequestArray(),
        );
    }
}
