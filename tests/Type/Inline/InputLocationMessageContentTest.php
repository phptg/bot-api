<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\Inline\InputLocationMessageContent;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InputLocationMessageContentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InputLocationMessageContent(1.1, 2.2);

        assertSame(1.1, $type->latitude);
        assertSame(2.2, $type->longitude);
        assertNull($type->horizontalAccuracy);
        assertNull($type->livePeriod);
        assertNull($type->heading);
        assertNull($type->proximityAlertRadius);
        assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $type = new InputLocationMessageContent(1.1, 2.2, 3.4, 60, 90, 100);

        assertSame(1.1, $type->latitude);
        assertSame(2.2, $type->longitude);
        assertSame(3.4, $type->horizontalAccuracy);
        assertSame(60, $type->livePeriod);
        assertSame(90, $type->heading);
        assertSame(100, $type->proximityAlertRadius);
        assertSame(
            [
                'latitude' => 1.1,
                'longitude' => 2.2,
                'horizontal_accuracy' => 3.4,
                'live_period' => 60,
                'heading' => 90,
                'proximity_alert_radius' => 100,
            ],
            $type->toRequestArray(),
        );
    }
}
