<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputprofilephotoanimated
 *
 * @api
 */
final readonly class InputProfilePhotoAnimated implements InputProfilePhoto
{
    public function __construct(
        public InputFile $animation,
        public ?float $mainFrameTimestamp = null,
    ) {}

    public function getType(): string
    {
        return 'animated';
    }

    public function toRequestArray(FileCollector $fileCollector): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'animation' => 'attach://' . $fileCollector->add($this->animation),
                'main_frame_timestamp' => $this->mainFrameTimestamp,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
