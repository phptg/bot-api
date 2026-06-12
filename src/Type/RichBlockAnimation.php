<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockanimation
 *
 * @api
 */
final readonly class RichBlockAnimation implements RichBlock
{
    public function __construct(
        public Animation $animation,
        public ?true $hasSpoiler = null,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'animation';
    }
}
