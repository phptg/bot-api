<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockanchor
 *
 * @api
 */
final readonly class RichBlockAnchor implements RichBlock
{
    public function __construct(
        public string $name,
    ) {}

    public function getType(): string
    {
        return 'anchor';
    }
}
