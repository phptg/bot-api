<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#forumtopic
 *
 * @api
 */
final readonly class ForumTopic
{
    public function __construct(
        public int $messageThreadId,
        public string $name,
        public int $iconColor,
        public ?string $iconCustomEmojiId = null,
    ) {}
}
