<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#emojitypecustomemoji
 *
 * @api
 */
final readonly class EmojiTypeCustomEmoji implements EmojiType
{
    public function __construct(
        public string $customEmojiId,
    ) {}

    public function getType(): string
    {
        return 'custom_emoji';
    }
}
