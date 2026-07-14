<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockMap;
use Phptg\BotApi\Type\Location;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockMapTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.234, 5.678);
        $map = new InputRichBlockMap($location, 10, 400, 300);

        assertSame('map', $map->getType());
        assertSame(
            [
                'type' => 'map',
                'location' => ['latitude' => 1.234, 'longitude' => 5.678],
                'zoom' => 10,
                'width' => 400,
                'height' => 300,
            ],
            $map->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $location = new Location(1.234, 5.678);
        $map = new InputRichBlockMap($location, 10, 400, 300, new RichBlockCaption('caption'));

        assertSame(
            [
                'type' => 'map',
                'location' => ['latitude' => 1.234, 'longitude' => 5.678],
                'zoom' => 10,
                'width' => 400,
                'height' => 300,
                'caption' => ['text' => 'caption'],
            ],
            $map->toRequestArray(),
        );
    }
}
