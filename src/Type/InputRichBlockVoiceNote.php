<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockvoicenote
 *
 * @api
 */
final readonly class InputRichBlockVoiceNote implements InputRichBlock
{
    public function __construct(
        public InputMediaVoiceNote $voiceNote,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'voice_note';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'voice_note' => $this->voiceNote->toRequestArray($fileCollector),
                'caption' => $this->caption?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
