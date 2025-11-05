<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#botdescription
 *
 * @api
 */
final readonly class BotDescription
{
    public function __construct(
        public string $description,
    ) {}
}
