<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockphoto
 *
 * @api
 */
final readonly class InputRichBlockPhoto implements InputRichBlock
{
    public function __construct(
        public InputMediaPhoto $photo,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'photo';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'photo' => $this->photo->toRequestArray($fileCollector),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
