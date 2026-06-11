<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockvoicenote
 *
 * @api
 */
final readonly class RichBlockVoiceNote implements RichBlock
{
    public function __construct(
        public Voice $voiceNote,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'voice_note';
    }
}
