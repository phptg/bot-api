<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#shippingaddress
 *
 * @api
 */
final readonly class ShippingAddress
{
    public function __construct(
        public string $countryCode,
        public string $state,
        public string $city,
        public string $streetLine1,
        public string $streetLine2,
        public string $postCode,
    ) {}
}
