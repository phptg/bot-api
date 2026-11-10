<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatsharetheme
 *
 * @api
 */
interface ChatShareTheme
{
    public function getType(): string;
}
