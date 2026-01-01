<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\Story;

/**
 * @see https://core.telegram.org/bots/api#repoststory
 *
 * @template-implements MethodInterface<Story>
 *
 * @api
 */
final readonly class RepostStory implements MethodInterface
{
    public function __construct(
        private string $businessConnectionId,
        private int $fromChatId,
        private int $fromStoryId,
        private int $activePeriod,
        private ?bool $postToChatPage = null,
        private ?bool $protectContent = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'repostStory';
    }

    public function getData(): array
    {
        return array_filter([
            'business_connection_id' => $this->businessConnectionId,
            'from_chat_id' => $this->fromChatId,
            'from_story_id' => $this->fromStoryId,
            'active_period' => $this->activePeriod,
            'post_to_chat_page' => $this->postToChatPage,
            'protect_content' => $this->protectContent,
        ], static fn($value) => $value !== null);
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Story::class);
    }
}
