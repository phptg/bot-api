<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#tonnftattribute
 *
 * @api
 */
final readonly class TonNftAttribute
{
    public function __construct(
        public string $traitType,
        public string $value,
    ) {}
}
