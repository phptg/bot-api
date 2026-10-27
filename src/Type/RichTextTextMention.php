<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtexttextmention
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class RichTextTextMention implements RichText
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public User $user,
    ) {}

    public function getType(): string
    {
        return 'text_mention';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'user' => $this->user->toRequestArray(),
        ];
    }
}
