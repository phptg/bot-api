<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultgif
 *
 * @api
 */
final readonly class InlineQueryResultGif implements InlineQueryResult
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $id,
        public string $gifUrl,
        public string $thumbnailUrl,
        public ?int $gifWidth = null,
        public ?int $gifHeight = null,
        public ?int $gifDuration = null,
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
        return 'gif';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'gif_url' => $this->gifUrl,
                'gif_width' => $this->gifWidth,
                'gif_height' => $this->gifHeight,
                'gif_duration' => $this->gifDuration,
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
