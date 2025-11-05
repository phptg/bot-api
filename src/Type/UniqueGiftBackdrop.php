<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftbackdrop
 *
 * @api
 */
final readonly class UniqueGiftBackdrop
{
    public function __construct(
        public string $name,
        public UniqueGiftBackdropColors $colors,
        public int $rarityPerMille,
    ) {}
}
