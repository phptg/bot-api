<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\StoryAreaPosition;

use function PHPUnit\Framework\assertSame;

final class StoryAreaPositionTest extends TestCase
{
    public function testBase(): void
    {
        $position = new StoryAreaPosition(
            xPercentage: 50.0,
            yPercentage: 25.0,
            widthPercentage: 30.0,
            heightPercentage: 40.0,
            rotationAngle: 15.0,
            cornerRadiusPercentage: 5.0,
        );

        assertSame(50.0, $position->xPercentage);
        assertSame(25.0, $position->yPercentage);
        assertSame(30.0, $position->widthPercentage);
        assertSame(40.0, $position->heightPercentage);
        assertSame(15.0, $position->rotationAngle);
        assertSame(5.0, $position->cornerRadiusPercentage);
    }

    public function testToRequestArray(): void
    {
        $position = new StoryAreaPosition(
            xPercentage: 50.0,
            yPercentage: 25.0,
            widthPercentage: 30.0,
            heightPercentage: 40.0,
            rotationAngle: 15.0,
            cornerRadiusPercentage: 5.0,
        );

        assertSame(
            [
                'x_percentage' => 50.0,
                'y_percentage' => 25.0,
                'width_percentage' => 30.0,
                'height_percentage' => 40.0,
                'rotation_angle' => 15.0,
                'corner_radius_percentage' => 5.0,
            ],
            $position->toRequestArray(),
        );
    }
}
