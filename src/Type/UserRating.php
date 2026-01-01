<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#userrating
 *
 * @api
 */
final readonly class UserRating
{
    public function __construct(
        public int $level,
        public int $rating,
        public int $currentLevelRating,
        public ?int $nextLevelRating = null,
    ) {}
}
