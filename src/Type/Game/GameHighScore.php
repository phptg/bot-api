<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Game;

use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#gamehighscore
 *
 * @api
 */
final readonly class GameHighScore
{
    public function __construct(
        public int $position,
        public User $user,
        public int $score,
    ) {}
}
