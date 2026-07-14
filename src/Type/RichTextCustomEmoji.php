<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richtextcustomemoji
 *
 * @api
 */
final readonly class RichTextCustomEmoji implements RichText
{
    public function __construct(
        public string $customEmojiId,
        public string $alternativeText,
    ) {}

    public function getType(): string
    {
        return 'custom_emoji';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'custom_emoji_id' => $this->customEmojiId,
            'alternative_text' => $this->alternativeText,
        ];
    }
}
