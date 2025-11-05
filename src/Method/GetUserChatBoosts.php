<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\UserChatBoosts;

/**
 * @see https://core.telegram.org/bots/api#getuserchatboosts
 *
 * @template-implements MethodInterface<UserChatBoosts>
 */
final readonly class GetUserChatBoosts implements MethodInterface
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
        return 'getUserChatBoosts';
    }

    public function getData(): array
    {
        return [
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
        ];
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(UserChatBoosts::class);
    }
}
