<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmedialocation
 *
 * @api
 */
final readonly class InputMediaLocation implements InputPollMedia, InputPollOptionMedia
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?float $horizontalAccuracy = null,
    ) {}

    public function getType(): string
    {
        return 'location';
    }

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'horizontal_accuracy' => $this->horizontalAccuracy,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
