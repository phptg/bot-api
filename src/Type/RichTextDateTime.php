<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

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

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'unix_time' => $this->unixTime,
            'date_time_format' => $this->dateTimeFormat,
        ];
    }
}
