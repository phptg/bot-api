<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#community
 *
 * @api
 */
final readonly class Community
{
    public function __construct(
        public int $id,
        public string $name,
    ) {}
}
