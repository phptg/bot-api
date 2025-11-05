<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\Type\Sticker\Sticker;

/**
 * @see https://core.telegram.org/bots/api#businessintro
 *
 * @api
 */
final readonly class BusinessIntro
{
    public function __construct(
        public ?string $title = null,
        public ?string $message = null,
        public ?Sticker $sticker = null,
    ) {}
}
