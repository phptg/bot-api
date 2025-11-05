<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Sticker;

use Phptg\BotApi\Type\File;
use Phptg\BotApi\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#sticker
 *
 * @api
 */
final readonly class Sticker
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public string $type,
        public int $width,
        public int $height,
        public bool $isAnimated,
        public bool $isVideo,
        public ?PhotoSize $thumbnail = null,
        public ?string $emoji = null,
        public ?string $setName = null,
        public ?File $premiumAnimation = null,
        public ?MaskPosition $maskPosition = null,
        public ?string $customEmojiId = null,
        public ?bool $needsRepainting = null,
        public ?int $fileSize = null,
    ) {}
}
