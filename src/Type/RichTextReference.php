<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextreference
 *
 * @api
 */
final readonly class RichTextReference implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $name,
    ) {}

    public function getType(): string
    {
        return 'reference';
    }
}
