<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#replyparameters
 *
 * @api
 */
final readonly class ReplyParameters
{
    /**
     * @param MessageEntity[]|null $quoteEntities
     */
    public function __construct(
        public int $messageId,
        public int|string|null $chatId = null,
        public ?bool $allowSendingWithoutReply = null,
        public ?string $quote = null,
        public ?string $quoteParseMode = null,
        public ?array $quoteEntities = null,
        public ?int $quotePosition = null,
        public ?int $checklistTaskId = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'message_id' => $this->messageId,
                'chat_id' => $this->chatId,
                'allow_sending_without_reply' => $this->allowSendingWithoutReply,
                'quote' => $this->quote,
                'quote_parse_mode' => $this->quoteParseMode,
                'quote_entities' => $this->quoteEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->quoteEntities,
                ),
                'quote_position' => $this->quotePosition,
                'checklist_task_id' => $this->checklistTaskId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
