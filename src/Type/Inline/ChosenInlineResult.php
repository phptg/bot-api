<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\Location;
use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#choseninlineresult
 *
 * @api
 */
final readonly class ChosenInlineResult
{
    public function __construct(
        public string $resultId,
        public User $from,
        public string $query,
        public ?Location $location = null,
        public ?string $inlineMessageId = null,
    ) {}
}
