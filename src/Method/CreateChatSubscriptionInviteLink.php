<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ChatInviteLink;

/**
 * @see https://core.telegram.org/bots/api#createchatsubscriptioninvitelink
 *
 * @template-implements MethodInterface<ChatInviteLink>
 */
final readonly class CreateChatSubscriptionInviteLink implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $subscriptionPeriod,
        private int $subscriptionPrice,
        private ?string $name = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'createChatSubscriptionInviteLink';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'name' => $this->name,
                'subscription_period' => $this->subscriptionPeriod,
                'subscription_price' => $this->subscriptionPrice,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(ChatInviteLink::class);
    }
}
