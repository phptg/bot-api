<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method\UpdatingMessage;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#deletemessage
 *
 * @template-implements MethodInterface<true>
 */
final readonly class DeleteMessage implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'deleteMessage';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_id' => $this->messageId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
