<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#reactiontype
 *
 * @api
 */
interface ReactionType
{
    public function getType(): string;

    public function toRequestArray(): array;
}
