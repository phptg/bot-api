<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\RichTextConverter;

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

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'text' => RichTextConverter::toRequestArray($this->text),
            'cashtag' => $this->cashtag,
        ];
    }
}
