<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#reactioncount
 *
 * @api
 */
final readonly class ReactionCount
{
    public function __construct(
        public ReactionType $type,
        public int $totalCount,
    ) {}
}
