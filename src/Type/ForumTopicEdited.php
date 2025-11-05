<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#forumtopicedited
 *
 * @api
 */
final readonly class ForumTopicEdited
{
    public function __construct(
        public ?string $name = null,
        public ?string $iconCustomEmojiId = null,
    ) {}
}
