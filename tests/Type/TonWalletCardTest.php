<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\AreaPosition;
use Phptg\BotApi\Type\TonNft;
use Phptg\BotApi\Type\TonWalletCard;
use Phptg\BotApi\Type\TonWalletCardSticker;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TonWalletCardTest extends TestCase
{
    public function testBase(): void
    {
        $sticker = new TonWalletCardSticker(
            new AreaPosition(50.0, 25.0, 30.0, 40.0, 15.0, 5.0),
            new TonNft('EQABnft', '1', 'NftName', 'NftDescription'),
        );
        $card = new TonWalletCard('EQCDwallet', '100500', [$sticker]);

        assertSame('EQCDwallet', $card->address);
        assertSame('100500', $card->amount);
        assertSame([$sticker], $card->stickers);
        assertNull($card->backgroundNftAddress);
    }

    public function testFull(): void
    {
        $sticker = new TonWalletCardSticker(
            new AreaPosition(50.0, 25.0, 30.0, 40.0, 15.0, 5.0),
            new TonNft('EQABnft', '1', 'NftName', 'NftDescription'),
        );
        $card = new TonWalletCard('EQCDwallet', '100500', [$sticker], 'EQABnft');

        assertSame('EQCDwallet', $card->address);
        assertSame('100500', $card->amount);
        assertSame([$sticker], $card->stickers);
        assertSame('EQABnft', $card->backgroundNftAddress);
    }

    public function testFromTelegramResult(): void
    {
        $card = (new ObjectFactory())->create([
            'address' => 'EQCDwallet',
            'amount' => '100500',
            'stickers' => [
                [
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
                ],
            ],
        ], null, TonWalletCard::class);

        assertSame('EQCDwallet', $card->address);
        assertSame('100500', $card->amount);
        $sticker = $card->stickers[0];
        assertInstanceOf(TonWalletCardSticker::class, $sticker);
        assertSame(50.0, $sticker->position->xPercentage);
        assertSame(15.0, $sticker->position->rotationAngle);
        assertSame('EQABnft', $sticker->nft->address);
        assertSame('NftName', $sticker->nft->name);
        assertNull($card->backgroundNftAddress);
    }

    public function testFromTelegramResultFull(): void
    {
        $card = (new ObjectFactory())->create([
            'address' => 'EQCDwallet',
            'amount' => '100500',
            'stickers' => [
                [
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
                ],
            ],
            'background_nft_address' => 'EQABnft',
        ], null, TonWalletCard::class);

        assertSame('EQCDwallet', $card->address);
        assertSame('100500', $card->amount);
        assertInstanceOf(TonWalletCardSticker::class, $card->stickers[0]);
        assertSame('EQABnft', $card->backgroundNftAddress);
    }
}
