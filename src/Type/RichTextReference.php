<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextreference
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class RichTextReference implements RichText
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $name,
    ) {}

    public function getType(): string
    {
        return 'reference';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'name' => $this->name,
        ];
    }
}
