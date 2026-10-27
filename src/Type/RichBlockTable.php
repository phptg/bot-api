<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfArraysOfObjectsValue;
use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblocktable
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class RichBlockTable implements RichBlock
{
    /**
     * @param list<list<RichBlockTableCell>> $cells
     * @param RichTextContent|null $caption
     */
    public function __construct(
        #[ArrayOfArraysOfObjectsValue(RichBlockTableCell::class)]
        public array $cells,
        public ?true $isBordered = null,
        public ?true $isStriped = null,
        #[RichTextValue]
        public string|array|RichText|null $caption = null,
        public ?true $isCompact = null,
    ) {}

    public function getType(): string
    {
        return 'table';
    }
}
