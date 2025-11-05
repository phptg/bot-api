<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#messageautodeletetimerchanged
 *
 * @api
 */
final readonly class MessageAutoDeleteTimerChanged
{
    public function __construct(
        public int $messageAutoDeleteTime,
    ) {}
}
