<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectOrTrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\MessageEntity;

/**
 * @see https://core.telegram.org/bots/api#editmessagecaption
 *
 * @template-implements MethodInterface<Message|true>
 */
final readonly class EditMessageCaption implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        private ?string $businessConnectionId = null,
        private int|string|null $chatId = null,
        private ?int $messageId = null,
        private ?string $inlineMessageId = null,
        private ?string $caption = null,
        private ?string $parseMode = null,
        private ?array $captionEntities = null,
        private ?bool $showCaptionAboveMedia = null,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editMessageCaption';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'inline_message_id' => $this->inlineMessageId,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn($value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectOrTrueValue
    {
        return new ObjectOrTrueValue(Message::class);
    }
}
