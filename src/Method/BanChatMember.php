<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use DateTimeInterface;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#banchatmember
 *
 * @template-implements MethodInterface<true>
 */
final readonly class BanChatMember implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private ?DateTimeInterface $untilDate = null,
        private ?bool $revokeMessages = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'banChatMember';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'user_id' => $this->userId,
                'until_date' => $this->untilDate?->getTimestamp(),
                'revoke_messages' => $this->revokeMessages,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
