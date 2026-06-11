<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#richblockdivider
 *
 * @api
 */
final readonly class RichBlockDivider implements RichBlock
{
    public function getType(): string
    {
        return 'divider';
    }
}
