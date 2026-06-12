<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockvideo
 *
 * @api
 */
final readonly class RichBlockVideo implements RichBlock
{
    public function __construct(
        public Video $video,
        public ?true $hasSpoiler = null,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'video';
    }
}
