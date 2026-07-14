<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InlineKeyboardMarkup;

/**
 * @see https://core.telegram.org/bots/api#editephemeralmessagereplymarkup
 *
 * @template-implements MethodInterface<true>
 */
final readonly class EditEphemeralMessageReplyMarkup implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $receiverUserId,
        private int $ephemeralMessageId,
        private ?InlineKeyboardMarkup $replyMarkup = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editEphemeralMessageReplyMarkup';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'receiver_user_id' => $this->receiverUserId,
                'ephemeral_message_id' => $this->ephemeralMessageId,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
