<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Sticker;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#gifts
 *
 * @api
 */
final readonly class Gifts
{
    /**
     * @param Gift[] $gifts
     */
    public function __construct(
        #[ArrayOfObjectsValue(Gift::class)]
        public array $gifts,
    ) {}
}
