<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultvenue
 *
 * @api
 */
final readonly class InlineQueryResultVenue implements InlineQueryResult
{
    public function __construct(
        public string $id,
        public float $latitude,
        public float $longitude,
        public string $title,
        public string $address,
        public ?string $foursquareId = null,
        public ?string $foursquareType = null,
        public ?string $googlePlaceId = null,
        public ?string $googlePlaceType = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
        public ?string $thumbnailUrl = null,
        public ?int $thumbnailWidth = null,
        public ?int $thumbnailHeight = null,
    ) {}

    public function getType(): string
    {
        return 'venue';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'title' => $this->title,
                'address' => $this->address,
                'foursquare_id' => $this->foursquareId,
                'foursquare_type' => $this->foursquareType,
                'google_place_id' => $this->googlePlaceId,
                'google_place_type' => $this->googlePlaceType,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                'input_message_content' => $this->inputMessageContent?->toRequestArray(),
                'thumbnail_url' => $this->thumbnailUrl,
                'thumbnail_width' => $this->thumbnailWidth,
                'thumbnail_height' => $this->thumbnailHeight,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
