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
}
