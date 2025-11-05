<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#precheckoutquery
 *
 * @api
 */
final readonly class PreCheckoutQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $currency,
        public int $totalAmount,
        public string $invoicePayload,
        public ?string $shippingOptionId = null,
        public ?OrderInfo $orderInfo = null,
    ) {}
}
