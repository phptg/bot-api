<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyareatypelink
 *
 * @api
 */
final readonly class StoryAreaTypeLink implements StoryAreaType
{
    public function __construct(
        public string $url,
    ) {}

    public function getType(): string
    {
        return 'link';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'url' => $this->url,
        ];
    }
}
