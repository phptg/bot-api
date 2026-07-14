<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichmessage
 *
 * @api
 */
final readonly class InputRichMessage
{
    /**
     * @param InputRichMessageMedia[]|null $media
     */
    public function __construct(
        public ?string $html = null,
        public ?string $markdown = null,
        public ?true $isRtl = null,
        public ?true $skipEntityDetection = null,
        public ?array $media = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'html' => $this->html,
                'markdown' => $this->markdown,
                'media' => $this->media === null ? null : array_map(
                    static fn(InputRichMessageMedia $media) => $media->toRequestArray($fileCollector),
                    $this->media,
                ),
                'is_rtl' => $this->isRtl,
                'skip_entity_detection' => $this->skipEntityDetection,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
