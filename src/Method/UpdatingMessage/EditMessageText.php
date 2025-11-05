<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectOrTrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\LinkPreviewOptions;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#editmessagetext
 *
 * @template-implements MethodInterface<Message|true>
 */
final readonly class EditMessageText implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        private string $text,
        private ?string $businessConnectionId = null,
        private int|string|null $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
        private ?string $parseMode = null,
        private ?array $entities = null,
        private ?LinkPreviewOptions $linkPreviewOptions = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editMessageText';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
                'text' => $this->text,
                'parse_mode' => $this->parseMode,
                'entities' => $this->entities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->entities,
                ),
                'link_preview_options' => $this->linkPreviewOptions?->toRequestArray(),
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectOrTrueValue
    {
        return new ObjectOrTrueValue(Message::class);
    }
}
