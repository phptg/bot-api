<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockaudio
 *
 * @api
 */
final readonly class InputRichBlockAudio implements InputRichBlock
{
    public function __construct(
        public InputMediaAudio $audio,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'audio';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'audio' => $this->audio->toRequestArray($fileCollector),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
