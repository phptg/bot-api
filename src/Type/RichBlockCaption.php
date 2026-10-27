<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richblockcaption
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class RichBlockCaption
{
    /**
     * @param RichTextContent $text
     * @param RichTextContent|null $credit
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        #[RichTextValue]
        public string|array|RichText|null $credit = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array
    {
        return array_filter(
            [
                'text' => RichTextConverter::toRequestArray($this->text),
                'credit' => RichTextConverter::toRequestArray($this->credit),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
