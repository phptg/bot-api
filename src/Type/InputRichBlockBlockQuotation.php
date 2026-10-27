<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockblockquotation
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class InputRichBlockBlockQuotation implements InputRichBlock
{
    /**
     * @param InputRichBlock[] $blocks
     * @param RichTextContent|null $credit
     */
    public function __construct(
        public array $blocks,
        public string|array|RichText|null $credit = null,
    ) {}

    public function getType(): string
    {
        return 'blockquote';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'blocks' => array_map(
                    static fn(InputRichBlock $block) => $block->toRequestArray($fileCollector),
                    $this->blocks,
                ),
                'credit' => RichTextConverter::toRequestArray($this->credit),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
