<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#reactiontypepaid
 *
 * @api
 */
final readonly class ReactionTypePaid implements ReactionType
{
    public function getType(): string
    {
        return 'paid';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
