<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatPermissions;

/**
 * @see https://core.telegram.org/bots/api#setchatpermissions
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetChatPermissions implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private ChatPermissions $permissions,
        private ?bool $useIndependentChatPermissions = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setChatPermissions';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'permissions' => $this->permissions->toRequestArray(),
                'use_independent_chat_permissions' => $this->useIndependentChatPermissions,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
