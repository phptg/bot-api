<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputMediaLocation;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaLocationTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaLocation(55.7558, 37.6173);

        assertSame('location', $inputMedia->getType());
        assertSame(
            [
                'type' => 'location',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'location',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $inputMedia = new InputMediaLocation(55.7558, 37.6173, 500.5);

        assertSame('location', $inputMedia->getType());
        assertSame(
            [
                'type' => 'location',
                'latitude' => 55.7558,
                'longitude' => 37.6173,
                'horizontal_accuracy' => 500.5,
            ],
            $inputMedia->toRequestArray(),
        );
    }
}
