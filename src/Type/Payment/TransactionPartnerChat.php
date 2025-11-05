<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Payment;

use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Sticker\Gift;

/**
 * @see https://core.telegram.org/bots/api#transactionpartnerchat
 *
 * @api
 */
final readonly class TransactionPartnerChat implements TransactionPartner
{
    public function __construct(
        public Chat $chat,
        public ?Gift $gift = null,
    ) {}

    public function getType(): string
    {
        return 'chat';
    }
}
