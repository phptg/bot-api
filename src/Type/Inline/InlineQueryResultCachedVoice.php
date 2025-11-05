<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultcachedvoice
 *
 * @api
 */
final readonly class InlineQueryResultCachedVoice implements InlineQueryResult
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $id,
        public string $voiceFileId,
        public string $title,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
    ) {}

    public function getType(): string
    {
        return 'voice';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'voice_file_id' => $this->voiceFileId,
                'title' => $this->title,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                'input_message_content' => $this->inputMessageContent?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
