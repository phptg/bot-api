<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#suggestedpostapproved
 *
 * @api
 */
final readonly class SuggestedPostApproved
{
    public function __construct(
        public int $sendDate,
        public ?Message $suggestedPostMessage = null,
        public ?SuggestedPostPrice $price = null,
    ) {}
}
