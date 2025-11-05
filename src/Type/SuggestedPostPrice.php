<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostprice
 *
 * @api
 */
final readonly class SuggestedPostPrice
{
    public function __construct(
        public string $currency,
        public int $amount,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'currency' => $this->currency,
            'amount' => $this->amount,
        ];
    }
}
