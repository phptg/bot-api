<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockanimation
 *
 * @api
 */
final readonly class InputRichBlockAnimation implements InputRichBlock
{
    public function __construct(
        public InputMediaAnimation $animation,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'animation';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'animation' => $this->animation->toRequestArray($fileCollector),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
