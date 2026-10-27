<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextanchorlink
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class RichTextAnchorLink implements RichText
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $anchorName,
    ) {}

    public function getType(): string
    {
        return 'anchor_link';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'anchor_name' => $this->anchorName,
        ];
    }
}
