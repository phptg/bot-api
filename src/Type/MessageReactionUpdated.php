<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\ReactionTypeValue;

/**
 * @see https://core.telegram.org/bots/api#messagereactionupdated
 *
 * @api
 */
final readonly class MessageReactionUpdated
{
    /**
     * @param ReactionType[] $oldReaction
     * @param ReactionType[] $newReaction
     */
    public function __construct(
        public Chat $chat,
        public int $messageId,
        public DateTimeImmutable $date,
        #[ArrayMap(ReactionTypeValue::class)]
        public array $oldReaction,
        #[ArrayMap(ReactionTypeValue::class)]
        public array $newReaction,
        public ?User $user = null,
        public ?Chat $actorChat = null,
    ) {}
}
