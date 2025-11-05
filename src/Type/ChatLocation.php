<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatlocation
 *
 * @api
 */
final readonly class ChatLocation
{
    public function __construct(
        public Location $location,
        public string $address,
    ) {}
}
