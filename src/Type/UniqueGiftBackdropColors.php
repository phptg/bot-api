<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftbackdropcolors
 *
 * @api
 */
final readonly class UniqueGiftBackdropColors
{
    public function __construct(
        public int $centerColor,
        public int $edgeColor,
        public int $symbolColor,
        public int $textColor,
    ) {}
}
