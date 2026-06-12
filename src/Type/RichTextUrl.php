<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtexturl
 *
 * @api
 */
final readonly class RichTextUrl implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $url,
    ) {}

    public function getType(): string
    {
        return 'url';
    }
}
