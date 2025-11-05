<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#giveawaywinners
 *
 * @api
 */
final readonly class GiveawayWinners
{
    /**
     * @param User[] $winners
     */
    public function __construct(
        public Chat $chat,
        public int $giveawayMessageId,
        public DateTimeImmutable $winnersSelectionDate,
        public int $winnerCount,
        #[ArrayOfObjectsValue(User::class)]
        public array $winners,
        public ?int $additionalChatCount = null,
        public ?int $premiumSubscriptionMonthCount = null,
        public ?int $unclaimedPrizeCount = null,
        public ?true $onlyNewMembers = null,
        public ?true $wasRefunded = null,
        public ?string $prizeDescription = null,
        public ?int $prizeStarCount = null,
    ) {}
}
