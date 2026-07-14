<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

/**
 * @see https://core.telegram.org/bots/api#richtextphonenumber
 *
 * @api
 */
final readonly class RichTextPhoneNumber implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $phoneNumber,
    ) {}

    public function getType(): string
    {
        return 'phone_number';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'phone_number' => $this->phoneNumber,
        ];
    }
}
