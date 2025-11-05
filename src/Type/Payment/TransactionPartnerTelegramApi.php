<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnertelegramapi
 *
 * @api
 */
final readonly class TransactionPartnerTelegramApi implements TransactionPartner
{
    public function __construct(
        public int $requestCount,
    ) {}

    public function getType(): string
    {
        return 'telegram_api';
    }
}
