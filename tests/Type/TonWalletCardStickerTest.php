<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\AreaPosition;
use Phptg\BotApi\Type\TonNft;
use Phptg\BotApi\Type\TonWalletCardSticker;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class TonWalletCardStickerTest extends TestCase
{
    public function testBase(): void
    {
        $position = new AreaPosition(50.0, 25.0, 30.0, 40.0, 15.0, 5.0);
        $nft = new TonNft('EQABnft', '1', 'NftName', 'NftDescription');
        $sticker = new TonWalletCardSticker($position, $nft);

        assertSame($position, $sticker->position);
        assertSame($nft, $sticker->nft);
    }

    public function testFromTelegramResult(): void
    {
        $sticker = (new ObjectFactory())->create([
            'position' => [
                'x_percentage' => 50.0,
                'y_percentage' => 25.0,
                'width_percentage' => 30.0,
                'height_percentage' => 40.0,
                'rotation_angle' => 15.0,
                'corner_radius_percentage' => 5.0,
            ],
            'nft' => [
                'address' => 'EQABnft',
                'index' => '1',
                'name' => 'NftName',
                'description' => 'NftDescription',
            ],
        ], null, TonWalletCardSticker::class);

        assertInstanceOf(AreaPosition::class, $sticker->position);
        assertSame(50.0, $sticker->position->xPercentage);
        assertSame(15.0, $sticker->position->rotationAngle);
        assertInstanceOf(TonNft::class, $sticker->nft);
        assertSame('EQABnft', $sticker->nft->address);
        assertSame('NftName', $sticker->nft->name);
    }
}
