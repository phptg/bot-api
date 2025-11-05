<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\MaskPosition;

use function PHPUnit\Framework\assertSame;

final class MaskPositionTest extends TestCase
{
    public function testMaskPosition(): void
    {
        $maskPosition = new MaskPosition(
            'forehead',
            0.5,
            0.6,
            0.7,
        );

        assertSame('forehead', $maskPosition->point);
        assertSame(0.5, $maskPosition->xShift);
        assertSame(0.6, $maskPosition->yShift);
        assertSame(0.7, $maskPosition->scale);
        assertSame(
            [
                'point' => 'forehead',
                'x_shift' => 0.5,
                'y_shift' => 0.6,
                'scale' => 0.7,
            ],
            $maskPosition->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $maskPosition = (new ObjectFactory())->create([
            'point' => 'forehead',
            'x_shift' => 0.5,
            'y_shift' => 0.6,
            'scale' => 0.7,
        ], null, MaskPosition::class);

        assertSame('forehead', $maskPosition->point);
        assertSame(0.5, $maskPosition->xShift);
        assertSame(0.6, $maskPosition->yShift);
        assertSame(0.7, $maskPosition->scale);
    }
}
