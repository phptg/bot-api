<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnertelegramads
 *
 * @api
 */
final readonly class TransactionPartnerTelegramAds implements TransactionPartner
{
    public function getType(): string
    {
        return 'telegram_ads';
    }
}
