<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftsymbol
 *
 * @api
 */
final readonly class UniqueGiftSymbol
{
    public function __construct(
        public string $name,
        public Sticker $sticker,
        public int $rarityPerMille,
    ) {}
}
