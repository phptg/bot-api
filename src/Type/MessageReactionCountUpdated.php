<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#messagereactioncountupdated
 *
 * @api
 */
final readonly class MessageReactionCountUpdated
{
    /**
     * @param ReactionCount[] $reactions
     */
    public function __construct(
        public Chat $chat,
        public int $messageId,
        public DateTimeImmutable $date,
        #[ArrayOfObjectsValue(ReactionCount::class)]
        public array $reactions,
    ) {}
}
