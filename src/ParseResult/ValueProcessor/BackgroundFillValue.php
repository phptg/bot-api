<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\BackgroundFill;
use Phptg\BotApi\Type\BackgroundFillFreeformGradient;
use Phptg\BotApi\Type\BackgroundFillGradient;
use Phptg\BotApi\Type\BackgroundFillSolid;

/**
 * @template-extends InterfaceValue<BackgroundFill>
 */
final readonly class BackgroundFillValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'solid' => BackgroundFillSolid::class,
            'gradient' => BackgroundFillGradient::class,
            'freeform_gradient' => BackgroundFillFreeformGradient::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown background fill type.';
    }
}
