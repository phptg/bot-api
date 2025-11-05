<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#shippingquery
 *
 * @api
 */
final readonly class ShippingQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $invoicePayload,
        public ShippingAddress $shippingAddress,
    ) {}
}
