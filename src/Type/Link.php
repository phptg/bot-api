<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#link
 *
 * @api
 */
final readonly class Link
{
    public function __construct(
        public string $url,
    ) {}
}
