<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ReactionType;

/**
 * @see https://core.telegram.org/bots/api#setmessagereaction
 *
 * @template-implements MethodInterface<true>
 */
final readonly class SetMessageReaction implements MethodInterface
{
    /**
     * @param ReactionType[]|null $reaction
     */
    public function __construct(
        private int|string $chatId,
        private int $messageId,
        private ?array $reaction = null,
        private ?bool $isBig = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'setMessageReaction';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_id' => $this->messageId,
                'reaction' => $this->reaction === null
                    ? null
                    : array_map(
                        static fn(ReactionType $reactionType) => $reactionType->toRequestArray(),
                        $this->reaction,
                    ),
                'is_big' => $this->isBig,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
