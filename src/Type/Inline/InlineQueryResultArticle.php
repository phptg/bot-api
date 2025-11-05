<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultarticle
 *
 * @api
 */
final readonly class InlineQueryResultArticle implements InlineQueryResult
{
    public function __construct(
        public string $id,
        public string $title,
        public InputMessageContent $inputMessageContent,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?string $url = null,
        public ?string $description = null,
        public ?string $thumbnailUrl = null,
        public ?int $thumbnailWidth = null,
        public ?int $thumbnailHeight = null,
    ) {}

    public function getType(): string
    {
        return 'article';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'title' => $this->title,
                'input_message_content' => $this->inputMessageContent->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                'url' => $this->url,
                'description' => $this->description,
                'thumbnail_url' => $this->thumbnailUrl,
                'thumbnail_width' => $this->thumbnailWidth,
                'thumbnail_height' => $this->thumbnailHeight,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
