<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblockcaption
 *
 * @api
 */
final readonly class RichBlockCaption
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        #[RichTextValue]
        public string|array|RichText|null $credit = null,
    ) {}
}
