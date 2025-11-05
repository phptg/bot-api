<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessOpeningHoursInterval;

use function PHPUnit\Framework\assertSame;

final class BusinessOpeningHoursIntervalTest extends TestCase
{
    public function testBase(): void
    {
        $interval = new BusinessOpeningHoursInterval(10, 100);

        assertSame(10, $interval->openingMinute);
        assertSame(100, $interval->closingMinute);
    }

    public function testFromTelegramResult(): void
    {
        $interval = (new ObjectFactory())->create([
            'opening_minute' => 10,
            'closing_minute' => 100,
        ], null, BusinessOpeningHoursInterval::class);

        assertSame(10, $interval->openingMinute);
        assertSame(100, $interval->closingMinute);
    }
}
