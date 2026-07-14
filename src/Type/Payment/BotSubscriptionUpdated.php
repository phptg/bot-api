<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#botsubscriptionupdated
 *
 * @api
 */
final readonly class BotSubscriptionUpdated
{
    public function __construct(
        public User $user,
        public string $invoicePayload,
        public string $state,
    ) {}
}
