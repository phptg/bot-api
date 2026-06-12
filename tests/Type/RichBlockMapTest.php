<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Location;
use Phptg\BotApi\Type\RichBlockMap;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockMapTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(55.75, 37.62);
        $map = new RichBlockMap($location, 15, 800, 600);

        assertSame('map', $map->getType());
        assertSame($location, $map->location);
        assertSame(15, $map->zoom);
        assertSame(800, $map->width);
        assertSame(600, $map->height);
        assertNull($map->caption);
    }

    public function testFull(): void
    {
        $location = new Location(55.75, 37.62);
        $caption = new RichBlockCaption('Moscow');
        $map = new RichBlockMap($location, 15, 800, 600, $caption);

        assertSame('map', $map->getType());
        assertSame($location, $map->location);
        assertSame(15, $map->zoom);
        assertSame(800, $map->width);
        assertSame(600, $map->height);
        assertSame($caption, $map->caption);
    }

    public function testFromTelegramResult(): void
    {
        $map = (new ObjectFactory())->create([
            'type' => 'map',
            'location' => ['latitude' => 55.75, 'longitude' => 37.62],
            'zoom' => 15,
            'width' => 800,
            'height' => 600,
        ], null, RichBlockMap::class);

        assertSame('map', $map->getType());
        assertInstanceOf(Location::class, $map->location);
        assertSame(15, $map->zoom);
        assertSame(800, $map->width);
        assertSame(600, $map->height);
        assertNull($map->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $map = (new ObjectFactory())->create([
            'type' => 'map',
            'location' => ['latitude' => 55.75, 'longitude' => 37.62],
            'zoom' => 15,
            'width' => 800,
            'height' => 600,
            'caption' => ['text' => 'Moscow'],
        ], null, RichBlockMap::class);

        assertSame('map', $map->getType());
        assertInstanceOf(Location::class, $map->location);
        assertSame(15, $map->zoom);
        assertSame(800, $map->width);
        assertSame(600, $map->height);
        assertInstanceOf(RichBlockCaption::class, $map->caption);
    }
}
