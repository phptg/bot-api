<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultvideo
 *
 * @api
 */
final readonly class InlineQueryResultVideo implements InlineQueryResult
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $id,
        public string $videoUrl,
        public string $mimeType,
        public string $thumbnailUrl,
        public string $title,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
        public ?int $videoWidth = null,
        public ?int $videoHeight = null,
        public ?int $videoDuration = null,
        public ?string $description = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
    ) {}

    public function getType(): string
    {
        return 'video';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'video_url' => $this->videoUrl,
                'mime_type' => $this->mimeType,
                'thumbnail_url' => $this->thumbnailUrl,
                'title' => $this->title,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'video_width' => $this->videoWidth,
                'video_height' => $this->videoHeight,
                'video_duration' => $this->videoDuration,
                'description' => $this->description,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                'input_message_content' => $this->inputMessageContent?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
