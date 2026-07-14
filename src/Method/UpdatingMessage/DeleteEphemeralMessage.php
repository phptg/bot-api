<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deleteephemeralmessage
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteEphemeralMessage implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $receiverUserId,
        private int $ephemeralMessageId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteEphemeralMessage';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'receiver_user_id' => $this->receiverUserId,
            'ephemeral_message_id' => $this->ephemeralMessageId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
