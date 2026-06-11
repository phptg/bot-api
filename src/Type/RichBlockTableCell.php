<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblocktablecell
 *
 * @api
 */
final readonly class RichBlockTableCell
{
    public function __construct(
        public string $align,
        public string $valign,
        #[RichTextValue]
        public string|array|RichText|null $text = null,
        public ?true $isHeader = null,
        public ?int $colspan = null,
        public ?int $rowspan = null,
    ) {}
}
