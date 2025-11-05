<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessLocation;
use Phptg\BotApi\Type\Location;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class BusinessLocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new BusinessLocation('street 7');

        assertSame('street 7', $location->address);
        assertNull($location->location);
    }

    public function testFromTelegramResult(): void
    {
        $location = (new ObjectFactory())->create([
            'address' => 'street 7',
            'location' => [
                'latitude' => 23.42,
                'longitude' => 42.23,
            ],
        ], null, BusinessLocation::class);

        assertSame('street 7', $location->address);

        assertInstanceOf(Location::class, $location->location);
        assertSame(23.42, $location->location->latitude);
    }
}
