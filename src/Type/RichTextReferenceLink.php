<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextreferencelink
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class RichTextReferenceLink implements RichText
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $referenceName,
    ) {}

    public function getType(): string
    {
        return 'reference_link';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'reference_name' => $this->referenceName,
        ];
    }
}
