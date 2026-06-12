<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\RichBlockValue;
use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblockblockquotation
 *
 * @api
 */
final readonly class RichBlockBlockQuotation implements RichBlock
{
    /**
     * @param list<RichBlock> $blocks
     */
    public function __construct(
        #[ArrayMap(RichBlockValue::class)]
        public array $blocks,
        #[RichTextValue]
        public string|array|RichText|null $credit = null,
    ) {}

    public function getType(): string
    {
        return 'blockquote';
    }
}
