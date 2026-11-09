<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;

/**
 * @see https://core.telegram.org/bots/api#textquote
 *
 * @api
 *
 * @phpstan-import-type RichTextContent from RichText
 */
final readonly class TextQuote
{
    /**
     * @param MessageEntity[]|null $entities
     * @param RichTextContent[]|null $richTexts
     */
    public function __construct(
        public string $text,
        public int $position,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isManual = null,
        #[ArrayMap(RichTextValue::class)]
        public ?array $richTexts = null,
    ) {}
}
