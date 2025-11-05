<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultmpeg4gif
 *
 * @api
 */
final readonly class InlineQueryResultMpeg4Gif implements InlineQueryResult
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $id,
        public string $mpeg4Url,
        public string $thumbnailUrl,
        public ?int $mpeg4Width = null,
        public ?int $mpeg4Height = null,
        public ?int $mpeg4Duration = null,
        public ?string $thumbnailMimeType = null,
        public ?string $title = null,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
    ) {}

    public function getType(): string
    {
        return 'mpeg4_gif';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'mpeg4_url' => $this->mpeg4Url,
                'mpeg4_width' => $this->mpeg4Width,
                'mpeg4_height' => $this->mpeg4Height,
                'mpeg4_duration' => $this->mpeg4Duration,
                'thumbnail_url' => $this->thumbnailUrl,
                'thumbnail_mime_type' => $this->thumbnailMimeType,
                'title' => $this->title,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                'input_message_content' => $this->inputMessageContent?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
