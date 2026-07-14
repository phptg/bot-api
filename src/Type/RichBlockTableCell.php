<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

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

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array
    {
        return array_filter(
            [
                'align' => $this->align,
                'valign' => $this->valign,
                'text' => RichTextConverter::toRequestArray($this->text),
                'is_header' => $this->isHeader,
                'colspan' => $this->colspan,
                'rowspan' => $this->rowspan,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
