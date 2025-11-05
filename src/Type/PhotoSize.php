<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#photosize
 *
 * @api
 */
final readonly class PhotoSize
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $width,
        public int $height,
        public ?int $fileSize = null,
    ) {}
}
