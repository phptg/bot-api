<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#forumtopiccreated
 *
 * @api
 */
final readonly class ForumTopicCreated
{
    public function __construct(
        public string $name,
        public int $iconColor,
        public ?string $iconCustomEmojiId = null,
        public ?true $isNameImplicit = null,
    ) {}
}
