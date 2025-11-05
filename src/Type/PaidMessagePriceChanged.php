<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#paidmessagepricechanged
 *
 * @api
 */
final readonly class PaidMessagePriceChanged
{
    public function __construct(
        public int $paidMessageStarCount,
    ) {}
}
