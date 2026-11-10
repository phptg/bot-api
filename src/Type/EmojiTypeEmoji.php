<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#emojitypeemoji
 *
 * @api
 */
final readonly class EmojiTypeEmoji implements EmojiType
{
    public function __construct(
        public string $emoji,
    ) {}

    public function getType(): string
    {
        return 'emoji';
    }
}
