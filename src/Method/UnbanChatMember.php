<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#unbanchatmember
 *
 * @template-implements MethodInterface<true>
 */
final readonly class UnbanChatMember implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private ?bool $onlyIfBanned = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'unbanChatMember';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'user_id' => $this->userId,
                'only_if_banned' => $this->onlyIfBanned,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
