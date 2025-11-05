<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputprofilephoto
 *
 * @api
 */
final readonly class InputProfilePhotoStatic implements InputProfilePhoto
{
    public function __construct(
        public InputFile $photo,
    ) {}

    public function getType(): string
    {
        return 'static';
    }

    public function toRequestArray(FileCollector $fileCollector): array
    {
        return [
            'type' => $this->getType(),
            'photo' => 'attach://' . $fileCollector->add($this->photo),
        ];
    }
}
