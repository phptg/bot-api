<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;
use Phptg\BotApi\ParseResult\ValueProcessor\IntegerValue;

/**
 * @see https://core.telegram.org/bots/api#backgroundfillfreeformgradient
 *
 * @api
 */
final readonly class BackgroundFillFreeformGradient implements BackgroundFill
{
    /**
     * @param int[] $colors
     */
    public function __construct(
        #[ArrayMap(IntegerValue::class)]
        public array $colors,
    ) {}

    public function getType(): string
    {
        return 'freeform_gradient';
    }
}
