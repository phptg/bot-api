<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#birthdate
 *
 * @api
 */
final readonly class Birthdate
{
    public function __construct(
        public int $day,
        public int $month,
        public ?int $year = null,
    ) {}
}
