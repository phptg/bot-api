<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextanchorlink
 *
 * @api
 */
final readonly class RichTextAnchorLink implements RichText
{
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
