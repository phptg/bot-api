<?php

declare(strict_types=1);

namespace Phptg\BotApi\Method;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\MethodInterface;
use Phptg\BotApi\Type\InputStoryContent;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\Story;
use Phptg\BotApi\Type\StoryArea;

/**
 * @see https://core.telegram.org/bots/api#poststory
 *
 * @template-implements MethodInterface<Story>
 *
 * @api
 */
final readonly class PostStory implements MethodInterface
{
    /**
     * @param MessageEntity[]|null $captionEntities
     * @param StoryArea[]|null $areas
     */
    public function __construct(
        private string $businessConnectionId,
        private InputStoryContent $content,
        private int $activePeriod,
        private ?string $caption = null,
        private ?string $parseMode = null,
        private ?array $captionEntities = null,
        private ?array $areas = null,
        private ?bool $postToChatPage = null,
        private ?bool $protectContent = null,
    ) {}

    public function getHttpMethod(): HttpMethod
    {
        return HttpMethod::POST;
    }

    public function getApiMethod(): string
    {
        return 'postStory';
    }

    public function getData(): array
    {
        $fileCollector = new FileCollector();
        $content = $this->content->toRequestArray($fileCollector);

        return array_filter(
            [
                'business_connection_id' => $this->businessConnectionId,
                'content' => $content,
                'active_period' => $this->activePeriod,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'areas' => $this->areas === null ? null : array_map(
                    static fn(StoryArea $area) => $area->toRequestArray(),
                    $this->areas,
                ),
                'post_to_chat_page' => $this->postToChatPage,
                'protect_content' => $this->protectContent,
                ...$fileCollector->get(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public function getResultType(): ObjectValue
    {
        return new ObjectValue(Story::class);
    }
}
