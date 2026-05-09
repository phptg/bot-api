<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#pollmedia
 *
 * @api
 */
final readonly class PollMedia
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public ?Animation $animation = null,
        public ?Audio $audio = null,
        public ?Document $document = null,
        public ?LivePhoto $livePhoto = null,
        public ?Location $location = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $photo = null,
        public ?Sticker $sticker = null,
        public ?Venue $venue = null,
        public ?Video $video = null,
    ) {}
}
