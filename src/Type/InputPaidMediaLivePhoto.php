<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmedialivephoto
 *
 * @api
 */
final readonly class InputPaidMediaLivePhoto implements InputPaidMedia
{
    public function __construct(
        public InputFile|string $media,
        public InputFile|string $photo,
    ) {}

    public function getType(): string
    {
        return 'live_photo';
    }

    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        if ($fileCollector !== null) {
            $media = $this->media instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->media)
                : $this->media;
            $photo = $this->photo instanceof InputFile
                ? 'attach://' . $fileCollector->add($this->photo)
                : $this->photo;
        } else {
            $media = $this->media;
            $photo = $this->photo;
        }

        return [
            'type' => $this->getType(),
            'media' => $media,
            'photo' => $photo,
        ];
    }
}
