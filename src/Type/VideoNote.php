<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#videonote
 *
 * @api
 */
final readonly class VideoNote
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $length,
        public int $duration,
        public ?PhotoSize $thumbnail = null,
        public ?int $fileSize = null,
    ) {}
}
