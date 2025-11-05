<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostinfo
 *
 * @api
 */
final readonly class SuggestedPostInfo
{
    public function __construct(
        public string $state,
        public ?SuggestedPostPrice $price = null,
        public ?int $sendDate = null,
    ) {}
}
