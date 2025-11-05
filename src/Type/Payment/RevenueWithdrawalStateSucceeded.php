<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#revenuewithdrawalstatesucceeded
 *
 * @api
 */
final readonly class RevenueWithdrawalStateSucceeded implements RevenueWithdrawalState
{
    public function __construct(
        public DateTimeImmutable $date,
        public string $url,
    ) {}

    public function getType(): string
    {
        return 'succeeded';
    }
}
