<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockmap
 *
 * @api
 */
final readonly class RichBlockMap implements RichBlock
{
    public function __construct(
        public Location $location,
        public int $zoom,
        public int $width,
        public int $height,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'map';
    }
}
