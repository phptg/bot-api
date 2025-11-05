<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#story
 *
 * @api
 */
final readonly class Story
{
    public function __construct(
        public Chat $chat,
        public int $id,
    ) {}
}
