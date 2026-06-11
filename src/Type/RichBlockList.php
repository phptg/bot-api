<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#richblocklist
 *
 * @api
 */
final readonly class RichBlockList implements RichBlock
{
    /**
     * @param list<RichBlockListItem> $items
     */
    public function __construct(
        #[ArrayOfObjectsValue(RichBlockListItem::class)]
        public array $items,
    ) {}

    public function getType(): string
    {
        return 'list';
    }
}
