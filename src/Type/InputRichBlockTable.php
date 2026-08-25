<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblocktable
 *
 * @api
 */
final readonly class InputRichBlockTable implements InputRichBlock
{
    /**
     * @param list<list<RichBlockTableCell>> $cells
     */
    public function __construct(
        public array $cells,
        public ?true $isBordered = null,
        public ?true $isStriped = null,
        public string|array|RichText|null $caption = null,
        public ?true $isCompact = null,
    ) {}

    public function getType(): string
    {
        return 'table';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'cells' => array_map(
                    static fn(array $row) => array_map(
                        static fn(RichBlockTableCell $cell) => $cell->toRequestArray(),
                        $row,
                    ),
                    $this->cells,
                ),
                'is_bordered' => $this->isBordered,
                'is_striped' => $this->isStriped,
                'is_compact' => $this->isCompact,
                'caption' => RichTextConverter::toRequestArray($this->caption),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
