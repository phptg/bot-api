<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyarea
 *
 * @api
 */
final readonly class StoryArea
{
    public function __construct(
        public StoryAreaPosition $position,
        public StoryAreaType $type,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'position' => $this->position->toRequestArray(),
            'type' => $this->type->toRequestArray(),
        ];
    }
}
