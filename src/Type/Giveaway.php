<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;

/**
 * @see https://core.telegram.org/bots/api#giveaway
 *
 * @api
 */
final readonly class Giveaway
{
    /**
     * @param Chat[] $chats
     * @param string[]|null $countryCodes
     */
    public function __construct(
        #[ArrayOfObjectsValue(Chat::class)]
        public array $chats,
        public DateTimeImmutable $winnersSelectionDate,
        public int $winnerCount,
        public ?true $onlyNewMembers = null,
        public ?true $hasPublicWinners = null,
        public ?string $prizeDescription = null,
        #[ArrayMap(StringValue::class)]
        public ?array $countryCodes = null,
        public ?int $premiumSubscriptionMonthCount = null,
        public ?int $prizeStarCount = null,
    ) {}
}
