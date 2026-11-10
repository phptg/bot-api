<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\Type\Inline\InputMessageContent;

/**
 * @see https://core.telegram.org/bots/api#inputwidgetmessagecontent
 *
 * @api
 */
final readonly class InputWidgetMessageContent implements InputMessageContent
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $html,
        public ?int $width = null,
        public ?int $height = null,
        public ?string $publicData = null,
        public ?string $chatData = null,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
        public ?bool $allowQueries = null,
        public ?bool $isShared = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'html' => $this->html,
                'width' => $this->width,
                'height' => $this->height,
                'public_data' => $this->publicData,
                'chat_data' => $this->chatData,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'allow_queries' => $this->allowQueries,
                'is_shared' => $this->isShared,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
