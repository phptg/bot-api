<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\StoryAreaTypeWeather;

use function PHPUnit\Framework\assertSame;

final class StoryAreaTypeWeatherTest extends TestCase
{
    public function testBase(): void
    {
        $weather = new StoryAreaTypeWeather(
            temperature: 25.5,
            emoji: '☀️',
            backgroundColor: 0xFFFFFF,
        );

        assertSame(25.5, $weather->temperature);
        assertSame('☀️', $weather->emoji);
        assertSame(0xFFFFFF, $weather->backgroundColor);
        assertSame('weather', $weather->getType());

        assertSame(
            [
                'type' => 'weather',
                'temperature' => 25.5,
                'emoji' => '☀️',
                'background_color' => 0xFFFFFF,
            ],
            $weather->toRequestArray(),
        );
    }
}
