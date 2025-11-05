<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessOpeningHours;
use Phptg\BotApi\Type\BusinessOpeningHoursInterval;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class BusinessOpeningHoursTest extends TestCase
{
    public function testBase(): void
    {
        $interval = new BusinessOpeningHoursInterval(10, 100);
        $businessOpeningHours = new BusinessOpeningHours(
            'Europe/Moscow',
            [$interval],
        );

        assertSame('Europe/Moscow', $businessOpeningHours->timeZoneName);
        assertSame([$interval], $businessOpeningHours->openingHours);
    }

    public function testFromTelegramResult(): void
    {
        $businessOpeningHours = (new ObjectFactory())->create([
            'time_zone_name' => 'Europe/Moscow',
            'opening_hours' => [
                [
                    'opening_minute' => 10,
                    'closing_minute' => 100,
                ],
            ],
        ], null, BusinessOpeningHours::class);

        assertSame('Europe/Moscow', $businessOpeningHours->timeZoneName);

        assertCount(1, $businessOpeningHours->openingHours);
        assertInstanceOf(BusinessOpeningHoursInterval::class, $businessOpeningHours->openingHours[0]);
        assertSame(10, $businessOpeningHours->openingHours[0]->openingMinute);
        assertSame(100, $businessOpeningHours->openingHours[0]->closingMinute);
    }
}
