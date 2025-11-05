<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultdocument
 *
 * @api
 */
final readonly class InlineQueryResultDocument implements InlineQueryResult
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $id,
        public string $title,
        public string $documentUrl,
        public string $mimeType,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?string $description = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
        public ?string $thumbnailUrl = null,
        public ?int $thumbnailWidth = null,
        public ?int $thumbnailHeight = null,
    ) {}

    public function getType(): string
    {
        return 'document';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'title' => $this->title,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'document_url' => $this->documentUrl,
                'mime_type' => $this->mimeType,
                'description' => $this->description,
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
