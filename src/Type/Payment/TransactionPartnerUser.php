<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\PaidMediaValue;
use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#transactionpartneruser
 *
 * @api
 */
final readonly class TransactionPartnerUser implements TransactionPartner
{
    public function __construct(
        public string $transactionType,
        public User $user,
        public ?string $invoicePayload = null,
        #[ArrayMap(PaidMediaValue::class)]
        public ?array $paidMedia = null,
        public ?string $paidMediaPayload = null,
        public ?int $subscriptionPeriod = null,
        public ?string $gift = null,
        public ?AffiliateInfo $affiliate = null,
        public ?int $premiumSubscriptionDuration = null,
    ) {}

    public function getType(): string
    {
        return 'user';
    }
}
