<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblockfooter
 *
 * @api
 */
final readonly class RichBlockFooter implements RichBlock
{
    /**
     * @param string|array<string|array<mixed>|RichText>|RichText $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
    ) {}

    public function getType(): string
    {
        return 'footer';
    }
}
