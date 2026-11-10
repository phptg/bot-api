<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\AreaPosition;
use Phptg\BotApi\Type\TonNft;
use Phptg\BotApi\Type\TonWalletCard;
use Phptg\BotApi\Type\TonWalletCardSticker;
use Phptg\BotApi\Type\WidgetQueryTypeData;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class WidgetQueryTypeDataTest extends TestCase
{
    public function testBase(): void
    {
        $queryType = new WidgetQueryTypeData();

        assertSame('data', $queryType->getType());
        assertNull($queryType->walletCard);
    }

    public function testFull(): void
    {
        $walletCard = new TonWalletCard('EQCDwallet', '100500', [
            new TonWalletCardSticker(
                new AreaPosition(50.0, 25.0, 30.0, 40.0, 15.0, 5.0),
                new TonNft('EQABnft', '1', 'NftName', 'NftDescription'),
            ),
        ]);
        $queryType = new WidgetQueryTypeData($walletCard);

        assertSame('data', $queryType->getType());
        assertSame($walletCard, $queryType->walletCard);
    }

    public function testFromTelegramResult(): void
    {
        $queryType = (new ObjectFactory())->create([
            'type' => 'data',
        ], null, WidgetQueryTypeData::class);

        assertSame('data', $queryType->getType());
        assertNull($queryType->walletCard);
    }

    public function testFromTelegramResultFull(): void
    {
        $queryType = (new ObjectFactory())->create([
            'type' => 'data',
            'wallet_card' => [
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
            ],
        ], null, WidgetQueryTypeData::class);

        assertSame('data', $queryType->getType());
        $walletCard = $queryType->walletCard;
        assertInstanceOf(TonWalletCard::class, $walletCard);
        assertSame('EQCDwallet', $walletCard->address);
        assertSame('EQABnft', $walletCard->backgroundNftAddress);
        assertInstanceOf(TonWalletCardSticker::class, $walletCard->stickers[0]);
        assertSame('EQABnft', $walletCard->stickers[0]->nft->address);
    }
}
