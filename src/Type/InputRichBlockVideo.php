<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockvideo
 *
 * @api
 */
final readonly class InputRichBlockVideo implements InputRichBlock
{
    public function __construct(
        public InputMediaVideo $video,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'video';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'video' => $this->video->toRequestArray($fileCollector),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
