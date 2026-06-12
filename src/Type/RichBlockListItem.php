<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\RichBlockValue;

/**
 * @see https://core.telegram.org/bots/api#richblocklistitem
 *
 * @api
 */
final readonly class RichBlockListItem
{
    /**
     * @param list<RichBlock> $blocks
     */
    public function __construct(
        public string $label,
        #[ArrayMap(RichBlockValue::class)]
        public array $blocks,
        public ?true $hasCheckbox = null,
        public ?true $isChecked = null,
        public ?int $value = null,
        public ?string $type = null,
    ) {}
}
