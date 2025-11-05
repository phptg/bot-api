<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\UniqueGiftBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftBackdropTest extends TestCase
{
    public function testBase(): void
    {
        $colors = new UniqueGiftBackdropColors(1, 2, 3, 4);
        $backdrop = new UniqueGiftBackdrop('backdropId', $colors, 200);

        assertSame('backdropId', $backdrop->name);
        assertSame($colors, $backdrop->colors);
        assertSame(200, $backdrop->rarityPerMille);
    }

    public function testFromTelegramResult(): void
    {
        $backdrop = (new ObjectFactory())->create([
            'name' => 'backdropId',
            'colors' => [
                'center_color' => 1,
                'edge_color' => 2,
                'symbol_color' => 3,
                'text_color' => 4,
            ],
            'rarity_per_mille' => 200,
        ], null, UniqueGiftBackdrop::class);

        assertInstanceOf(UniqueGiftBackdrop::class, $backdrop);
        assertSame('backdropId', $backdrop->name);
        assertSame(1, $backdrop->colors->centerColor);
        assertSame(2, $backdrop->colors->edgeColor);
        assertSame(3, $backdrop->colors->symbolColor);
        assertSame(4, $backdrop->colors->textColor);
        assertSame(200, $backdrop->rarityPerMille);
    }
}
