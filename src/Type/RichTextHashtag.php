<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtexthashtag
 *
 * @api
 */
final readonly class RichTextHashtag implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public string $hashtag,
    ) {}

    public function getType(): string
    {
        return 'hashtag';
    }
}
