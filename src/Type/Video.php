<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#video
 *
 * @api
 */
final readonly class Video
{
    /**
     * @param PhotoSize[]|null $cover
     */
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $width,
        public int $height,
        public int $duration,
        public ?PhotoSize $thumbnail = null,
        public ?string $fileName = null,
        public ?string $mimeType = null,
        public ?int $fileSize = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $cover = null,
        public ?int $startTimestamp = null,
    ) {}
}
