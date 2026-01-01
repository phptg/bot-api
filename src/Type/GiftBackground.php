<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#giftbackground
 *
 * @api
 */
final readonly class GiftBackground
{
    public function __construct(
        public int $centerColor,
        public int $edgeColor,
        public int $textColor,
    ) {}
}
