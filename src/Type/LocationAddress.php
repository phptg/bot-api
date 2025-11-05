<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#locationaddress
 *
 * @api
 */
final readonly class LocationAddress
{
    public function __construct(
        public string $countryCode,
        public ?string $state = null,
        public ?string $city = null,
        public ?string $street = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'country_code' => $this->countryCode,
                'state' => $this->state,
                'city' => $this->city,
                'street' => $this->street,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
