<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\Location;
use Phptg\BotApi\Type\User;

/**
 * @see https://core.telegram.org/bots/api#inlinequery
 *
 * @api
 */
final readonly class InlineQuery
{
    public function __construct(
        public string $id,
        public User $from,
        public string $query,
        public string $offset,
        public ?string $chatType = null,
        public ?Location $location = null,
    ) {}
}
