<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#document
 *
 * @api
 */
final readonly class Document
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public ?PhotoSize $thumbnail = null,
        public ?string $fileName = null,
        public ?string $mimeType = null,
        public ?int $fileSize = null,
    ) {}
}
