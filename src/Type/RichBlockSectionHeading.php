<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblocksectionheading
 *
 * @api
 *
 * @psalm-import-type RichTextContent from RichText
 */
final readonly class RichBlockSectionHeading implements RichBlock
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public int $size,
    ) {}

    public function getType(): string
    {
        return 'heading';
    }
}
