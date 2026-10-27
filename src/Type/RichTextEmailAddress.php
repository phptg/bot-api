<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextemailaddress
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class RichTextEmailAddress implements RichText
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $emailAddress,
    ) {}

    public function getType(): string
    {
        return 'email_address';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'email_address' => $this->emailAddress,
        ];
    }
}
