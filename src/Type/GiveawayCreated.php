<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#giveawaycreated
 *
 * @api
 */
final readonly class GiveawayCreated
{
    public function __construct(
        public ?int $prizeStarCount = null,
    ) {}
}
