<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultlocation
 *
 * @api
 */
final readonly class InlineQueryResultLocation implements InlineQueryResult
{
    public function __construct(
        public string $id,
        public float $latitude,
        public float $longitude,
        public string $title,
        public ?float $horizontalAccuracy = null,
        public ?int $livePeriod = null,
        public ?int $heading = null,
        public ?int $proximityAlertRadius = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
        public ?string $thumbnailUrl = null,
        public ?int $thumbnailWidth = null,
        public ?int $thumbnailHeight = null,
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
                'id' => $this->id,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'title' => $this->title,
                'horizontal_accuracy' => $this->horizontalAccuracy,
                'live_period' => $this->livePeriod,
                'heading' => $this->heading,
                'proximity_alert_radius' => $this->proximityAlertRadius,
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
