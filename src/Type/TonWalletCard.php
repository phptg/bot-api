<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#tonwalletcard
 *
 * @api
 */
final readonly class TonWalletCard
{
    /**
     * @param TonWalletCardSticker[] $stickers
     */
    public function __construct(
        public string $address,
        public string $amount,
        #[ArrayOfObjectsValue(TonWalletCardSticker::class)]
        public array $stickers,
        public ?string $backgroundNftAddress = null,
    ) {}
}
