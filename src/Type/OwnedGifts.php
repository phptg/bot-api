<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\OwnedGiftValue;

/**
 * @see https://core.telegram.org/bots/api#ownedgifts
 *
 * @api
 */
final readonly class OwnedGifts
{
    /**
     * @param OwnedGift[] $gifts
     */
    public function __construct(
        public int $totalCount,
        #[ArrayMap(OwnedGiftValue::class)]
        public array $gifts,
        public ?string $nextOffset = null,
    ) {}
}
