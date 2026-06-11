<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#richtextdatetime
 *
 * @api
 */
final readonly class RichTextDateTime implements RichText
{
    public function __construct(
        #[RichTextValue]
        public string|array|RichText $text,
        public int $unixTime,
        public string $dateTimeFormat,
    ) {}

    public function getType(): string
    {
        return 'date_time';
    }
}
