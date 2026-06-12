<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextemailaddress
 *
 * @api
 */
final readonly class RichTextEmailAddress implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $emailAddress,
    ) {}

    public function getType(): string
    {
        return 'email_address';
    }
}
