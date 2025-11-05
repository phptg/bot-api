<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatPermissions;

/**
 * @see https://core.telegram.org/bots/api#restrictchatmember
 *
 * @template-implements MethodInterface<true>
 */
final readonly class RestrictChatMember implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $userId,
        private ChatPermissions $permissions,
        private ?bool $useIndependentChatPermissions = null,
        private ?DateTimeImmutable $untilDate = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'restrictChatMember';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'user_id' => $this->userId,
                'permissions' => $this->permissions->toRequestArray(),
                'use_independent_chat_permissions' => $this->useIndependentChatPermissions,
                'until_date' => $this->untilDate?->getTimestamp(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
