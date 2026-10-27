<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\FileCollector;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#inputrichblockpullquotation
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class InputRichBlockPullQuotation implements InputRichBlock
{
    /**
     * @param RichTextContent $text
     * @param RichTextContent|null $credit
     */
    public function __construct(
        public string|array|RichText $text,
        public string|array|RichText|null $credit = null,
    ) {}

    public function getType(): string
    {
        return 'pullquote';
    }

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(?FileCollector $fileCollector = null): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'text' => RichTextConverter::toRequestArray($this->text),
                'credit' => RichTextConverter::toRequestArray($this->credit),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
