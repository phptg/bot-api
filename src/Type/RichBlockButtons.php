<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#richblockbuttons
 *
 * @api
 */
final readonly class RichBlockButtons implements RichBlock
{
    /**
     * @param list<RichMessageButton> $buttons
     */
    public function __construct(
        #[ArrayOfObjectsValue(RichMessageButton::class)]
        public array $buttons,
        public ?string $align = null,
    ) {}

    public function getType(): string
    {
        return 'buttons';
    }
}
