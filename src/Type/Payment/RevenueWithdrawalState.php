<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstate
 *
 * @api
 */
interface RevenueWithdrawalState
{
    public function getType(): string;
}
