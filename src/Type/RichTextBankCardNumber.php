<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextbankcardnumber
 *
 * @api
 */
final readonly class RichTextBankCardNumber implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $bankCardNumber,
    ) {}

    public function getType(): string
    {
        return 'bank_card_number';
    }
}
