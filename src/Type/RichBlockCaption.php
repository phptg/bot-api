<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richblockcaption
 *
 * @api
 */
final readonly class RichBlockCaption
{
    /**
     * @param string|array<string|array<mixed>|RichText>|RichText $text
     * @param string|array<string|array<mixed>|RichText>|RichText|null $credit
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
