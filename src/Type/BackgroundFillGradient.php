<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#backgroundfillgradient
 *
 * @api
 */
final readonly class BackgroundFillGradient implements BackgroundFill
{
    public function __construct(
        public int $topColor,
        public int $bottomColor,
        public int $rotationAngle,
    ) {}

    public function getType(): string
    {
        return 'gradient';
    }
}
