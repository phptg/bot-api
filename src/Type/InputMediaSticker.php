<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputmediasticker
 *
 * @api
 */
final readonly class InputMediaSticker implements InputPollOptionMedia
{
    public function __construct(
        public string|InputFile $media,
        public ?string $emoji = null,
    ) {}

    public function getType(): string
    {
        return 'sticker';
    }

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $media = $this->media instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->media)
                : $this->media;
        } else {
            $media = $this->media;
        }

        return array_filter(
            [
                'type' => $this->getType(),
                'media' => $media,
                'emoji' => $this->emoji,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
