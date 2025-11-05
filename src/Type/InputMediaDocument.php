<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmediadocument
 *
 * @api
 */
final readonly class InputMediaDocument implements InputMedia
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
        public ?bool $disableContentTypeDetection = null,
    ) {}

    public function getType(): string
    {
        return 'document';
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
        } else {
            $media = $this->media;
            $thumbnail = $this->thumbnail;
        }

        return array_filter(
            [
                'type' => $this->getType(),
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => $this->caption,
                'parse_mode' => $this->parseMode,
                'caption_entities' => $this->captionEntities === null ? null : array_map(
                    static fn(MessageEntity $entity) => $entity->toRequestArray(),
                    $this->captionEntities,
                ),
                'disable_content_type_detection' => $this->disableContentTypeDetection,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
