<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostparameters
 *
 * @api
 */
final readonly class SuggestedPostParameters
{
    public function __construct(
        public ?SuggestedPostPrice $price = null,
        public ?int $sendDate = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'price' => $this->price?->toRequestArray(),
                'send_date' => $this->sendDate,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
