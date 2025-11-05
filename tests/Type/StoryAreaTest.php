<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\StoryArea;
use Phptg\BotApi\Type\StoryAreaPosition;
use Phptg\BotApi\Type\StoryAreaTypeUniqueGift;

use function PHPUnit\Framework\assertSame;

final class StoryAreaTest extends TestCase
{
    public function testToRequestArray(): void
    {
        $position = new StoryAreaPosition(1, 2, 3, 4, 5, 6);
        $type = new StoryAreaTypeUniqueGift('Golden Trophy');
        $storyArea = new StoryArea($position, $type);

        assertSame(
            [
                'position' => $position->toRequestArray(),
                'type' => $type->toRequestArray(),
            ],
            $storyArea->toRequestArray(),
        );
    }
}
