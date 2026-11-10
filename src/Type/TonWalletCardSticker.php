<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#tonwalletcardsticker
 *
 * @api
 */
final readonly class TonWalletCardSticker
{
    public function __construct(
        public AreaPosition $position,
        public TonNft $nft,
    ) {}
}
