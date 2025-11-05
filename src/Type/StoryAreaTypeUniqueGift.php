<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyareatypeuniquegift
 *
 * @api
 */
final readonly class StoryAreaTypeUniqueGift implements StoryAreaType
{
    public function __construct(
        public string $name,
    ) {}

    public function getType(): string
    {
        return 'unique_gift';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'name' => $this->name,
        ];
    }
}
