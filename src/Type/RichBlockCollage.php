<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\RichBlockValue;

/**
 * @see https://core.telegram.org/bots/api#richblockcollage
 *
 * @api
 */
final readonly class RichBlockCollage implements RichBlock
{
    /**
     * @param list<RichBlock> $blocks
     */
    public function __construct(
        #[ArrayMap(RichBlockValue::class)]
        public array $blocks,
        public ?RichBlockCaption $caption = null,
    ) {}

    public function getType(): string
    {
        return 'collage';
    }
}
