<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Game;

/**
 * @see https://core.telegram.org/bots/api#callbackgame
 *
 * @api
 */
final readonly class CallbackGame
{
    public function toRequestArray(): array
    {
        return [];
    }
}
