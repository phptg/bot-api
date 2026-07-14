<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockmap
 *
 * @api
 */
final readonly class InputRichBlockMap implements InputRichBlock
{
    public function __construct(
        public Location $location,
        public int $zoom,
        public int $width,
        public int $height,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'map';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'location' => $this->location->toRequestArray(),
                'zoom' => $this->zoom,
                'width' => $this->width,
                'height' => $this->height,
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
