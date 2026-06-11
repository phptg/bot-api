<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextcashtag
 *
 * @api
 */
final readonly class RichTextCashtag implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $cashtag,
    ) {}

    public function getType(): string
    {
        return 'cashtag';
    }
}
