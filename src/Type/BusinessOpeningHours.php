<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#businessopeninghours
 *
 * @api
 */
final readonly class BusinessOpeningHours
{
    /**
     * @param BusinessOpeningHoursInterval[] $openingHours
     */
    public function __construct(
        public string $timeZoneName,
        #[ArrayOfObjectsValue(BusinessOpeningHoursInterval::class)]
        public array $openingHours,
    ) {}
}
