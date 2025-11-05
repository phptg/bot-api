<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#reopenforumtopic
 *
 * @template-implements MethodInterface<true>
 */
final readonly class ReopenForumTopic implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageThreadId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'reopenForumTopic';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'message_thread_id' => $this->messageThreadId,
        ];
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
