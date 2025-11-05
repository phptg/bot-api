<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmediavideo
 *
 * @api
 */
final readonly class InputMediaVideo implements InputMedia
{
    /**
     * @param MessageEntity[]|null $captionEntities
     */
    public function __construct(
        public string|InputFile $media,
        public string|InputFile|null $thumbnail = null,
        public ?string $caption = null,
        public ?string $parseMode = null,
        public ?array $captionEntities = null,
        public ?bool $showCaptionAboveMedia = null,
        public ?int $width = null,
        public ?int $height = null,
        public ?int $duration = null,
        public ?bool $supportsStreaming = null,
        public ?bool $hasSpoiler = null,
        public string|InputFile|null $cover = null,
        public ?int $startTimestamp = null,
    ) {}

    public function getType(): string
    {
        return 'video';
    }

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $media = $this->media instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->media)
                : $this->media;
            $thumbnail = $this->thumbnail instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->thumbnail)
                : $this->thumbnail;
            $cover = $this->cover instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->cover)
                : $this->cover;
        } else {
            $media = $this->media;
            $thumbnail = $this->thumbnail;
            $cover = $this->cover;
        }

        return array_filter(
            [
                'type' => $this->getType(),
                'media' => $media,
                'thumbnail' => $thumbnail,
                'cover' => $cover,
                'start_timestamp' => $this->startTimestamp,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'show_caption_above_media' => $this->showCaptionAboveMedia,
                'width' => $this->width,
                'height' => $this->height,
                'duration' => $this->duration,
                'supports_streaming' => $this->supportsStreaming,
                'has_spoiler' => $this->hasSpoiler,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
