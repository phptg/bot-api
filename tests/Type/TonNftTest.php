<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\TonNft;
use Phptg\BotApi\Type\TonNftAttribute;
use Phptg\BotApi\Type\UniqueGift;
use Phptg\BotApi\Type\UniqueGiftBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;
use Phptg\BotApi\Type\UniqueGiftModel;
use Phptg\BotApi\Type\UniqueGiftSymbol;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TonNftTest extends TestCase
{
    public function testBase(): void
    {
        $nft = new TonNft('EQABnft', '1', 'NftName', 'NftDescription');

        assertSame('EQABnft', $nft->address);
        assertSame('1', $nft->index);
        assertSame('NftName', $nft->name);
        assertSame('NftDescription', $nft->description);
        assertNull($nft->collectionAddress);
        assertNull($nft->attributes);
        assertNull($nft->gift);
    }

    public function testFull(): void
    {
        $gift = new UniqueGift(
            'gift-id-456',
            'baseName',
            'uniqueName',
            1,
            new UniqueGiftModel(
                'id1',
                new Sticker(
                    'x1',
                    'fullX1',
                    'unique',
                    100,
                    120,
                    false,
                    true,
                ),
                200,
            ),
            new UniqueGiftSymbol(
                'id2',
                new Sticker(
                    'x1',
                    'fullX1',
                    'unique',
                    100,
                    120,
                    false,
                    true,
                ),
                200,
            ),
            new UniqueGiftBackdrop(
                'id3',
                new UniqueGiftBackdropColors(1, 2, 3, 4),
                200,
            ),
        );
        $attributes = [new TonNftAttribute('color', 'blue')];
        $nft = new TonNft(
            'EQABnft',
            '1',
            'NftName',
            'NftDescription',
            'EQCDcollection',
            $attributes,
            $gift,
        );

        assertSame('EQABnft', $nft->address);
        assertSame('1', $nft->index);
        assertSame('NftName', $nft->name);
        assertSame('NftDescription', $nft->description);
        assertSame('EQCDcollection', $nft->collectionAddress);
        assertSame($attributes, $nft->attributes);
        assertSame($gift, $nft->gift);
    }

    public function testFromTelegramResult(): void
    {
        $nft = (new ObjectFactory())->create([
            'address' => 'EQABnft',
            'index' => '1',
            'name' => 'NftName',
            'description' => 'NftDescription',
        ], null, TonNft::class);

        assertSame('EQABnft', $nft->address);
        assertSame('1', $nft->index);
        assertSame('NftName', $nft->name);
        assertSame('NftDescription', $nft->description);
        assertNull($nft->collectionAddress);
        assertNull($nft->attributes);
        assertNull($nft->gift);
    }

    public function testFromTelegramResultFull(): void
    {
        $nft = (new ObjectFactory())->create([
            'address' => 'EQABnft',
            'collection_address' => 'EQCDcollection',
            'index' => '1',
            'name' => 'NftName',
            'description' => 'NftDescription',
            'attributes' => [
                [
                    'trait_type' => 'color',
                    'value' => 'blue',
                ],
            ],
            'gift' => [
                'gift_id' => 'gift-id-456',
                'base_name' => 'baseName',
                'name' => 'uniqueName',
                'number' => 1,
                'model' => [
                    'name' => 'id1',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'unique',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'rarity_per_mille' => 200,
                ],
                'symbol' => [
                    'name' => 'id2',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'unique',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'rarity_per_mille' => 200,
                ],
                'backdrop' => [
                    'name' => 'id3',
                    'colors' => [
                        'center_color' => 1,
                        'edge_color' => 2,
                        'symbol_color' => 3,
                        'text_color' => 4,
                    ],
                    'rarity_per_mille' => 200,
                ],
            ],
        ], null, TonNft::class);

        assertSame('EQABnft', $nft->address);
        assertSame('EQCDcollection', $nft->collectionAddress);
        assertSame('1', $nft->index);
        assertSame('NftName', $nft->name);
        assertSame('NftDescription', $nft->description);
        assertIsArray($nft->attributes);
        assertInstanceOf(TonNftAttribute::class, $nft->attributes[0]);
        assertSame('color', $nft->attributes[0]->traitType);
        assertInstanceOf(UniqueGift::class, $nft->gift);
        assertSame('gift-id-456', $nft->gift->giftId);
    }
}
