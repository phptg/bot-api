<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

/**
 * @see https://core.telegram.org/bots/api#inputvenuemessagecontent
 *
 * @api
 */
final readonly class InputVenueMessageContent implements InputMessageContent
{
    public function __construct(
        public float $latitude,
        public float $longitude,
        public string $title,
        public string $address,
        public ?string $foursquareId = null,
        public ?string $foursquareType = null,
        public ?string $googlePlaceId = null,
        public ?string $googlePlaceType = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'title' => $this->title,
                'address' => $this->address,
                'foursquare_id' => $this->foursquareId,
                'foursquare_type' => $this->foursquareType,
                'google_place_id' => $this->googlePlaceId,
                'google_place_type' => $this->googlePlaceType,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
