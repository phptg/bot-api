<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#tonwallettransfer
 *
 * @api
 */
final readonly class TonWalletTransfer
{
    public function __construct(
        public string $transactionId,
        public string $peerAddress,
        public string $amount,
        public ?string $comment = null,
    ) {}
}
