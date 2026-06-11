<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextsubscript
 *
 * @api
 */
final readonly class RichTextSubscript implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
    ) {}

    public function getType(): string
    {
        return 'subscript';
    }
}
