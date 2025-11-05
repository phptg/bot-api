<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatboost
 *
 * @api
 */
final readonly class ChatBoost
{
    public function __construct(
        public string $boostId,
        public DateTimeImmutable $addDate,
        public DateTimeImmutable $expirationDate,
        public ChatBoostSource $source,
    ) {}
}
