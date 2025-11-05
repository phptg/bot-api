<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Type\PhotoSize;

/**
 * @see https://core.telegram.org/bots/api#stickerset
 *
 * @api
 */
final readonly class StickerSet
{
    /**
     * @param Sticker[] $stickers
     */
    public function __construct(
        public string $name,
        public string $title,
        public string $stickerType,
        #[ArrayOfObjectsValue(Sticker::class)]
        public array $stickers,
        public ?PhotoSize $thumbnail = null,
    ) {}
}
