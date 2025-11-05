<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\ForumTopic;

/**
 * @see https://core.telegram.org/bots/api#createforumtopic
 *
 * @template-implements MethodInterface<ForumTopic>
 */
final readonly class CreateForumTopic implements MethodInterface
{
    public function __construct(
        private int|string $chatId,
        private string $name,
        private ?int $iconColor = null,
        private ?string $iconCustomEmojiId = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'createForumTopic';
    }

    public function getData(): array
    {
        return array_filter(
            [
                'chat_id' => $this->chatId,
                'name' => $this->name,
                'icon_color' => $this->iconColor,
                'icon_custom_emoji_id' => $this->iconCustomEmojiId,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(ForumTopic::class);
    }
}
