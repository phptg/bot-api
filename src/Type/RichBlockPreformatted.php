<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richblockpreformatted
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class RichBlockPreformatted implements RichBlock
{
    /**
     * @param RichTextContent $text
     */
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public ?string $language = null,
    ) {}

    public function getType(): string
    {
        return 'pre';
    }
}
