<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatboostsourcegiveaway
 *
 * @api
 */
final readonly class ChatBoostSourceGiveaway implements ChatBoostSource
{
    public function __construct(
        public int $giveawayMessageId,
        public ?User $user = null,
        public ?true $isUnclaimed = null,
        public ?int $prizeStarCount = null,
    ) {}

    public function getSource(): string
    {
        return 'giveaway';
    }

    public function getUser(): ?User
    {
        return $this->user;
    }
}
