<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#transactionpartner
 *
 * @api
 */
interface TransactionPartner
{
    public function getType(): string;
}
