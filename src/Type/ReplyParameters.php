<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#replyparameters
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class ReplyParameters
{
    /**
     * @param MessageEntity[]|null $quoteEntities
     * @param RichTextContent[]|null $quoteRichTexts
     */
    public function __construct(
        public ?int $messageId = null,
        public int|string|null $chatId = null,
        public ?bool $allowSendingWithoutReply = null,
        public ?string $quote = null,
        public ?string $quoteParseMode = null,
        public ?array $quoteEntities = null,
        public ?int $quotePosition = null,
        public ?int $checklistTaskId = null,
        public ?string $pollOptionId = null,
        public ?int $ephemeralMessageId = null,
        public ?array $quoteRichTexts = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array
    {
        return array_filter(
            [
                'message_id' => $this->messageId,
                'chat_id' => $this->chatId,
                'ephemeral_message_id' => $this->ephemeralMessageId,
                'allow_sending_without_reply' => $this->allowSendingWithoutReply,
                'quote' => $this->quote,
                'quote_parse_mode' => $this->quoteParseMode,
                'quote_entities' => $this->quoteEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->quoteEntities,
                ),
                'quote_rich_texts' => $this->quoteRichTexts === null ? null : array_map(
                    RichTextConverter::toRequestArray(...),
                    $this->quoteRichTexts,
                ),
                'quote_position' => $this->quotePosition,
                'checklist_task_id' => $this->checklistTaskId,
                'poll_option_id' => $this->pollOptionId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
