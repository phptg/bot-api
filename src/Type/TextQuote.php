<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#textquote
 *
 * @api
 */
final readonly class TextQuote
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public string $text,
        public int $position,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isManual = null,
    ) {}
}
