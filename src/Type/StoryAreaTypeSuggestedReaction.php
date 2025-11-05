<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyareatypesuggestedreaction
 *
 * @api
 */
final readonly class StoryAreaTypeSuggestedReaction implements StoryAreaType
{
    public function __construct(
        public ReactionType $reactionType,
        public ?bool $isDark = null,
        public ?bool $isFlipped = null,
    ) {}

    public function getType(): string
    {
        return 'suggested_reaction';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'reaction_type' => $this->reactionType->toRequestArray(),
                'is_dark' => $this->isDark,
                'is_flipped' => $this->isFlipped,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
