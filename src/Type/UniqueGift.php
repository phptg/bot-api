<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#uniquegift
 *
 * @api
 */
final readonly class UniqueGift
{
    public function __construct(
        public string $giftId,
        public string $baseName,
        public string $name,
        public int $number,
        public UniqueGiftModel $model,
        public UniqueGiftSymbol $symbol,
        public UniqueGiftBackdrop $backdrop,
        public ?true $isPremium = null,
        public ?true $isFromBlockchain = null,
        public ?UniqueGiftColors $colors = null,
        public ?Chat $publisherChat = null,
        public ?true $isBurned = null,
    ) {}
}
