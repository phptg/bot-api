<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#staramount
 *
 * @api
 */
final readonly class StarAmount
{
    public function __construct(
        public int $amount,
        public ?int $nanostarAmount = null,
    ) {}
}
