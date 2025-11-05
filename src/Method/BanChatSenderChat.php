<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#banchatsenderchat
 *
 * @template-implements MethodInterface<true>
 */
final readonly class BanChatSenderChat implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $senderChatId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'banChatSenderChat';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'sender_chat_id' => $this->senderChatId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
