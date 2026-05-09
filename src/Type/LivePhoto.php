<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#livephoto
 *
 * @api
 */
final readonly class LivePhoto
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $width,
        public int $height,
        public int $duration,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $photo = null,
        public ?string $mimeType = null,
        public ?string $fileSize = null,
    ) {}
}
