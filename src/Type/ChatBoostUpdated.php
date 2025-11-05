<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostupdated
 *
 * @api
 */
final readonly class ChatBoostUpdated
{
    public function __construct(
        public Chat $chat,
        public ChatBoost $boost,
    ) {}
}
