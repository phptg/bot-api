<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#storyareaposition
 *
 * @api
 */
final readonly class StoryAreaPosition
{
    public function __construct(
        public float $xPercentage,
        public float $yPercentage,
        public float $widthPercentage,
        public float $heightPercentage,
        public float $rotationAngle,
        public float $cornerRadiusPercentage,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'x_percentage' => $this->xPercentage,
            'y_percentage' => $this->yPercentage,
            'width_percentage' => $this->widthPercentage,
            'height_percentage' => $this->heightPercentage,
            'rotation_angle' => $this->rotationAngle,
            'corner_radius_percentage' => $this->cornerRadiusPercentage,
        ];
    }
}
