<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockslideshow
 *
 * @api
 */
final readonly class InputRichBlockSlideshow implements InputRichBlock
{
    /**
     * @param InputRichBlock[] $blocks
     */
    public function __construct(
        public array $blocks,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'slideshow';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'blocks' => array_map(
                    static fn(InputRichBlock $block) => $block->toRequestArray($fileCollector),
                    $this->blocks,
                ),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
