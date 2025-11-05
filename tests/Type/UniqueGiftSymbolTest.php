<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\UniqueGiftSymbol;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class UniqueGiftSymbolTest extends TestCase
{
    public function testBase(): void
    {
        $sticker = new Sticker('stickerId', 'uniqueStickerId', 'unique', 100, 120, false, true);
        $symbol = new UniqueGiftSymbol('symbolId', $sticker, 300);

        assertSame('symbolId', $symbol->name);
        assertSame($sticker, $symbol->sticker);
        assertSame(300, $symbol->rarityPerMille);
    }

    public function testFromTelegramResult(): void
    {
        $symbol = (new ObjectFactory())->create([
            'name' => 'symbolId',
            'sticker' => [
                'file_id' => 'stickerId',
                'file_unique_id' => 'uniqueStickerId',
                'type' => 'unique',
                'width' => 100,
                'height' => 120,
                'is_animated' => false,
                'is_video' => true,
            ],
            'rarity_per_mille' => 300,
        ], null, UniqueGiftSymbol::class);

        assertInstanceOf(UniqueGiftSymbol::class, $symbol);
        assertSame('symbolId', $symbol->name);
        assertSame('stickerId', $symbol->sticker->fileId);
        assertSame(300, $symbol->rarityPerMille);
    }
}
