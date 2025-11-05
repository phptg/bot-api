<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#startransaction
 *
 * @api
 */
final readonly class StarTransaction
{
    public function __construct(
        public string $id,
        public int $amount,
        public DateTimeImmutable $date,
        public ?TransactionPartner $source = null,
        public ?TransactionPartner $receiver = null,
        public ?int $nanostarAmount = null,
    ) {}
}
