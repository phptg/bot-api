<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostpaid
 *
 * @api
 */
final readonly class SuggestedPostPaid
{
    public function __construct(
        public string $currency,
        public ?Message $suggestedPostMessage = null,
        public ?int $amount = null,
        public ?StarAmount $starAmount = null,
    ) {}
}
