<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#giveawaycompleted
 *
 * @api
 */
final readonly class GiveawayCompleted
{
    public function __construct(
        public int $winnerCount,
        public ?int $unclaimedPrizeCount = null,
        public ?Message $giveawayMessage = null,
        public ?true $isStarGiveaway = null,
    ) {}
}
