<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextmarked
 *
 * @api
 */
final readonly class RichTextMarked implements RichText
{
    /**
     * @param string|array<string|array<mixed>|RichText>|RichText $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
    ) {}

    public function getType(): string
    {
        return 'marked';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
        ];
    }
}
