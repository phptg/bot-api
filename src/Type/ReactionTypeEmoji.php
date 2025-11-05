<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#reactiontypeemoji
 *
 * @api
 */
final readonly class ReactionTypeEmoji implements ReactionType
{
    public function __construct(
        public string $emoji,
    ) {}

    public function getType(): string
    {
        return 'emoji';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'emoji' => $this->emoji,
        ];
    }
}
