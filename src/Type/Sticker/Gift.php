<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Sticker;

use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\GiftBackground;

/**
 * @see https://core.telegram.org/bots/api#gift
 *
 * @api
 */
final readonly class Gift
{
    public function __construct(
        public string $id,
        public Sticker $sticker,
        public int $starCount,
        public ?int $upgradeStarCount = null,
        public ?true $isPremium = null,
        public ?true $hasColors = null,
        public ?int $totalCount = null,
        public ?int $remainingCount = null,
        public ?int $personalTotalCount = null,
        public ?int $personalRemainingCount = null,
        public ?GiftBackground $background = null,
        public ?int $uniqueGiftVariantCount = null,
        public ?Chat $publisherChat = null,
    ) {}
}
