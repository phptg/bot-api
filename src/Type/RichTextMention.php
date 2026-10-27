<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextmention
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class RichTextMention implements RichText
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $username,
    ) {}

    public function getType(): string
    {
        return 'mention';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'username' => $this->username,
        ];
    }
}
