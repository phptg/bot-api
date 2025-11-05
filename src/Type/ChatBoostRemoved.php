<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatboostremoved
 *
 * @api
 */
final readonly class ChatBoostRemoved
{
    public function __construct(
        public Chat $chat,
        public string $boostId,
        public DateTimeImmutable $removeDate,
        public ChatBoostSource $source,
    ) {}
}
