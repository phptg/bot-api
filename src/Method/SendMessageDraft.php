<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#sendmessagedraft
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SendMessageDraft implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        private int $chatId,
        private int $draftId,
        private string $text,
        private ?int $messageThreadId = null,
        private ?string $parseMode = null,
        private ?array $entities = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'sendMessageDraft';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'draft_id' => $this->draftId,
                'text' => $this->text,
                'parse_mode' => $this->parseMode,
                'entities' => $this->entities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->entities,
                ),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
