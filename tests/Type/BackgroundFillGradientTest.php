<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BackgroundFillGradient;

use function PHPUnit\Framework\assertSame;

final class BackgroundFillGradientTest extends TestCase
{
    public function testBase(): void
    {
        $fill = new BackgroundFillGradient(0x000000, 0xFFFFFF, 17);

        assertSame('gradient', $fill->getType());
        assertSame(0x000000, $fill->topColor);
        assertSame(0xFFFFFF, $fill->bottomColor);
        assertSame(17, $fill->rotationAngle);
    }

    public function testFromTelegramResult(): void
    {
        $fill = (new ObjectFactory())->create([
            'type' => 'gradient',
            'top_color' => 0x000000,
            'bottom_color' => 0xFFFFFF,
            'rotation_angle' => 17,
        ], null, BackgroundFillGradient::class);

        assertSame('gradient', $fill->getType());
        assertSame(0x000000, $fill->topColor);
        assertSame(0xFFFFFF, $fill->bottomColor);
        assertSame(17, $fill->rotationAngle);
    }
}
