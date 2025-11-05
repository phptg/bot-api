<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundtypefill
 *
 * @api
 */
final readonly class BackgroundTypeFill implements BackgroundType
{
    public function __construct(
        public BackgroundFill $fill,
        public int $darkThemeDimming,
    ) {}

    public function getType(): string
    {
        return 'fill';
    }
}
