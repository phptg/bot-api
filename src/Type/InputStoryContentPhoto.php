<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputstorycontentphoto
 *
 * @api
 */
final readonly class InputStoryContentPhoto implements InputStoryContent
{
    public function __construct(
        public InputFile $photo,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }

    public function toRequestArray(FileCollector $fileCollector): array
    {
        return [
            'type' => $this->getType(),
            'photo' => 'attach://' . $fileCollector->add($this->photo),
        ];
    }
}
