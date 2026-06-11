<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockaudio
 *
 * @api
 */
final readonly class RichBlockAudio implements RichBlock
{
    public function __construct(
        public Audio $audio,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'audio';
    }
}
