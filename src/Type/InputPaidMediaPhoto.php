<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputpaidmediaphoto
 *
 * @api
 */
final readonly class InputPaidMediaPhoto implements InputPaidMedia
{
    public function __construct(
        public string|InputFile $media,
    ) {}

    public function getType(): string
    {
        return 'photo';
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

        return [
            'type' => $this->getType(),
            'media' => $media,
        ];
    }
}
