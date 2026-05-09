<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputMediaVenue;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaVenueTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaVenue(55.7558, 37.6173, 'The Kremlin', 'Red Square, Moscow');

        assertSame('venue', $inputMedia->getType());
        assertSame(
            [
                'type' => 'venue',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'title' => 'The Kremlin',
                'address' => 'Red Square, Moscow',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'venue',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'title' => 'The Kremlin',
                'address' => 'Red Square, Moscow',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $inputMedia = new InputMediaVenue(
            55.7558,
            37.6173,
            'The Kremlin',
            'Red Square, Moscow',
            'foursquare_id_123',
            'arts_entertainment/landmark',
            'google_place_id_456',
            'point_of_interest',
        );

        assertSame('venue', $inputMedia->getType());
        assertSame(
            [
                'type' => 'venue',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'title' => 'The Kremlin',
                'address' => 'Red Square, Moscow',
                'foursquare_id' => 'foursquare_id_123',
                'foursquare_type' => 'arts_entertainment/landmark',
                'google_place_id' => 'google_place_id_456',
                'google_place_type' => 'point_of_interest',
            ],
            $inputMedia->toRequestArray(),
        );
    }
}
