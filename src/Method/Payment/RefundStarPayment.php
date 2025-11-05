<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\Payment;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#refundstarpayment
 *
 * @template-implements MethodInterface<true>
 */
final readonly class RefundStarPayment implements MethodInterface
{
    public function __construct(
        private int $userId,
        private string $telegramPaymentChargeId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'refundStarPayment';
    }

    public function getData(): array
    {
        return [
            'user_id' => $this->userId,
            'telegram_payment_charge_id' => $this->telegramPaymentChargeId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
