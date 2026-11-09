<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\Type\Inline\InputMessageContent;

/**
 * @see https://core.telegram.org/bots/api#inputsharedwidgetmessagecontent
 *
 * @api
 */
final readonly class InputSharedWidgetMessageContent implements InputMessageContent
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string $widgetId,
        public ?string $chatData = null,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'widget_id' => $this->widgetId,
                'chat_data' => $this->chatData,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
