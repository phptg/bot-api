<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatLocation;
use Phptg\BotApi\Type\Location;

use function PHPUnit\Framework\assertSame;

final class ChatLocationTest extends TestCase
{
    public function testBase(): void
    {
        $location = new Location(1.1, 2.2);
        $chatLocation = new ChatLocation($location, 'Test');

        assertSame($location, $chatLocation->location);
        assertSame('Test', $chatLocation->address);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'location' => [
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            'address' => 'Test',
        ];

        $chatLocation = (new ObjectFactory())->create($result, null, ChatLocation::class);

        assertSame(1.1, $chatLocation->location->latitude);
        assertSame('Test', $chatLocation->address);
    }
}
