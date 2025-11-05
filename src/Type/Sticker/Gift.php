<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Sticker;

use Phptg\BotApi\Type\Chat;

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
        public ?int $totalCount = null,
        public ?int $remainingCount = null,
        public ?int $upgradeStarCount = null,
        public ?Chat $publisherChat = null,
    ) {}
}
