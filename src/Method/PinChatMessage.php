<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#pinchatmessage
 *
 * @template-implements MethodInterface<true>
 */
final readonly class PinChatMessage implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageId,
        private ?bool $disableNotification = null,
        private ?string $businessConnectionId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'pinChatMessage';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'disable_notification' => $this->disableNotification,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
