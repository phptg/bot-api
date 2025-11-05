<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostrefunded
 *
 * @api
 */
final readonly class SuggestedPostRefunded
{
    public function __construct(
        public string $reason,
        public ?Message $suggestedPostMessage = null,
    ) {}
}
