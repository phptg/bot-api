<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#reactiontypecustomemoji
 *
 * @api
 */
final readonly class ReactionTypeCustomEmoji implements ReactionType
{
    public function __construct(
        public string $customEmojiId,
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
        ];
    }
}
