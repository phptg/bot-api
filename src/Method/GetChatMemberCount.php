<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#getchatmembercount
 *
 * @template-implements MethodInterface<int>
 */
final readonly class GetChatMemberCount implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChatMemberCount';
    }

    public function getData(): array
    {
        return ['chat_id' => $this->chatId];
    }

    public function getResultType(): IntegerValue
    {
        return new IntegerValue();
    }
}
