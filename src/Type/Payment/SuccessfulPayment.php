<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#successfulpayment
 *
 * @api
 */
final readonly class SuccessfulPayment
{
    public function __construct(
        public string $currency,
        public int $totalAmount,
        public string $invoicePayload,
        public string $telegramPaymentChargeId,
        public string $providerPaymentChargeId,
        public ?string $shippingOptionId = null,
        public ?OrderInfo $orderInfo = null,
        public ?DateTimeImmutable $subscriptionExpirationDate = null,
        public ?true $isRecurring = null,
        public ?true $isFirstRecurring = null,
    ) {}
}
