<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#dice
 *
 * @api
 */
final readonly class Dice
{
    public function __construct(
        public string $emoji,
        public int $value,
    ) {}
}
