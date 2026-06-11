<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\RichBlockValue;
use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblockdetails
 *
 * @api
 */
final readonly class RichBlockDetails implements RichBlock
{
    /**
     * @param list<RichBlock> $blocks
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $summary,
        #[ArrayMap(RichBlockValue::class)]
        public array $blocks,
        public ?true $isOpen = null,
    ) {}

    public function getType(): string
    {
        return 'details';
    }
}
