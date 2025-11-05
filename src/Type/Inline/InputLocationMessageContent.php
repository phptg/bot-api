<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

/**
 * @see https://core.telegram.org/bots/api#inputlocationmessagecontent
 *
 * @api
 */
final readonly class InputLocationMessageContent implements InputMessageContent
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public ?float $horizontalAccuracy = null,
        public ?int $livePeriod = null,
        public ?int $heading = null,
        public ?int $proximityAlertRadius = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'horizontal_accuracy' => $this->horizontalAccuracy,
                'live_period' => $this->livePeriod,
                'heading' => $this->heading,
                'proximity_alert_radius' => $this->proximityAlertRadius,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
