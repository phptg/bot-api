<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyareatypelocation
 *
 * @api
 */
final readonly class StoryAreaTypeLocation implements StoryAreaType
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?LocationAddress $address = null,
    ) {}

    public function getType(): string
    {
        return 'location';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'address' => $this->address?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
