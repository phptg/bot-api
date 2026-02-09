<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#videoquality
 *
 * @api
 */
final readonly class VideoQuality
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $width,
        public int $height,
        public string $codec,
        public ?int $fileSize = null,
    ) {}
}
