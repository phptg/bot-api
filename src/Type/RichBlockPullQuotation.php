<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblockpullquotation
 *
 * @api
 */
final readonly class RichBlockPullQuotation implements RichBlock
{
    /**
     * @param string|array<string|array<mixed>|RichText>|RichText $text
     * @param string|array<string|array<mixed>|RichText>|RichText|null $credit
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        #[RichTextValue]
        public string|array|RichText|null $credit = null,
    ) {}

    public function getType(): string
    {
        return 'pullquote';
    }
}
