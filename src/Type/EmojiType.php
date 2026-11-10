<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#emojitype
 *
 * @api
 */
interface EmojiType
{
    public function getType(): string;
}
