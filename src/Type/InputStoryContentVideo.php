<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputstorycontentvideo
 *
 * @api
 */
final readonly class InputStoryContentVideo implements InputStoryContent
{
    public function __construct(
        public InputFile $video,
        public ?float $duration = null,
        public ?float $coverFrameTimestamp = null,
        public ?bool $isAnimation = null,
    ) {}

    public function getType(): string
    {
        return 'video';
    }

    public function toRequestArray(FileCollector $fileCollector): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'video' => 'attach://' . $fileCollector->add($this->video),
                'duration' => $this->duration,
                'cover_frame_timestamp' => $this->coverFrameTimestamp,
                'is_animation' => $this->isAnimation,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
