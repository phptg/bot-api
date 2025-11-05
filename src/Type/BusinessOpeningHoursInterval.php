<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghoursinterval
 *
 * @api
 */
final readonly class BusinessOpeningHoursInterval
{
    public function __construct(
        public int $openingMinute,
        public int $closingMinute,
    ) {}
}
