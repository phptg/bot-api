<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\TrueValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;

/**
 * @see https://core.telegram.org/bots/api#editforumtopic
 *
 * @template-implements MethodInterface<true>
 */
final readonly class EditForumTopic implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private int $messageThreadId,
        private ?string $name = null,
        private ?string $iconCustomEmojiId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'editForumTopic';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'message_thread_id' => $this->messageThreadId,
                'name' => $this->name,
                'icon_custom_emoji_id' => $this->iconCustomEmojiId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): TrueValue
    {
        return new TrueValue();
    }
}
