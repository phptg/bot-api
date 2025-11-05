<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostadded
 *
 * @api
 */
final readonly class ChatBoostAdded
{
    public function __construct(
        public int $boostCount,
    ) {}
}
