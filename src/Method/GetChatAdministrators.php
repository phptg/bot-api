<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\ChatMemberValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatMember;

/**
 * @see https://core.telegram.org/bots/api#getchatadministrators
 *
 * @template-implements MethodInterface<array<ChatMember>>
 */
final readonly class GetChatAdministrators implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private ?bool $returnBots = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::GET;
    }

    public function getApiMethod(): string
    {
        return 'getChatAdministrators';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'return_bots' => $this->returnBots,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ArrayMap
    {
        return new ArrayMap(ChatMemberValue::class);
    }
}
