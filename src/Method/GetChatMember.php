<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ChatMemberValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatMember;

/**
 * @see https://core.telegram.org/bots/api#getchatmember
 *
 * @template-implements MethodInterface<ChatMember>
 */
final readonly class GetChatMember implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChatMember';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
        ];
    }

    public function getResultType(): ChatMemberValue
    {
        return new ChatMemberValue();
    }
}
