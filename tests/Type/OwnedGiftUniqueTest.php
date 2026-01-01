<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\OwnedGiftUnique;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\UniqueGift;
use Phptg\BotApi\Type\UniqueGiftBackdrop;
use Phptg\BotApi\Type\UniqueGiftBackdropColors;
use Phptg\BotApi\Type\UniqueGiftModel;
use Phptg\BotApi\Type\UniqueGiftSymbol;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class OwnedGiftUniqueTest extends TestCase
{
    public function testBase(): void
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
        $sendDate = new DateTimeImmutable();
        $ownedGift = new OwnedGiftUnique($gift, $sendDate);

        assertSame('unique', $ownedGift->getType());
        assertSame($gift, $ownedGift->gift);
        assertSame($sendDate, $ownedGift->sendDate);
        assertNull($ownedGift->ownedGiftId);
        assertNull($ownedGift->senderUser);
        assertNull($ownedGift->isSaved);
        assertNull($ownedGift->canBeTransferred);
        assertNull($ownedGift->transferStarCount);
        assertNull($ownedGift->nextTransferDate);
    }

    public function testFull(): void
    {
        $gift = new UniqueGift(
            'gift-id-789',
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
        $sendDate = new DateTimeImmutable();
        $senderUser = new User(123, false, 'John');
        $nextTransferDate = new DateTimeImmutable('+1 day');
        $ownedGift = new OwnedGiftUnique(
            $gift,
            $sendDate,
            'ownedGiftId1',
            $senderUser,
            true,
            true,
            10,
            $nextTransferDate,
        );

        assertSame($gift, $ownedGift->gift);
        assertSame($sendDate, $ownedGift->sendDate);
        assertSame('ownedGiftId1', $ownedGift->ownedGiftId);
        assertSame($senderUser, $ownedGift->senderUser);
        assertSame(true, $ownedGift->isSaved);
        assertSame(true, $ownedGift->canBeTransferred);
        assertSame(10, $ownedGift->transferStarCount);
        assertSame('unique', $ownedGift->getType());
        assertSame($nextTransferDate, $ownedGift->nextTransferDate);
    }

    public function testFromTelegramResult(): void
    {
        $ownedGift = (new ObjectFactory())->create([
            'gift' => [
                'gift_id' => 'gift-unique-xyz',
                'base_name' => 'BaseName',
                'name' => 'uniqueName',
                'number' => 1,
                'model' => [
                    'name' => 'test1',
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
                    'name' => 'test2',
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
                    'name' => 'test3',
                    'colors' => [
                        'center_color' => 1,
                        'edge_color' => 2,
                        'symbol_color' => 3,
                        'text_color' => 4,
                    ],
                    'rarity_per_mille' => 200,
                ],
            ],
            'owned_gift_id' => 'ownedGiftId1',
            'sender_user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'send_date' => 1619040000,
            'is_saved' => true,
            'can_be_transferred' => true,
            'transfer_star_count' => 10,
            'next_transfer_date' => 1723050000,
        ], null, OwnedGiftUnique::class);

        assertInstanceOf(OwnedGiftUnique::class, $ownedGift);
        assertSame('BaseName', $ownedGift->gift->baseName);
        assertSame('ownedGiftId1', $ownedGift->ownedGiftId);
        assertInstanceOf(User::class, $ownedGift->senderUser);
        assertSame(123, $ownedGift->senderUser->id);
        assertEquals(new DateTimeImmutable('@1619040000'), $ownedGift->sendDate);
        assertTrue($ownedGift->isSaved);
        assertTrue($ownedGift->canBeTransferred);
        assertSame(10, $ownedGift->transferStarCount);
        assertSame(1723050000, $ownedGift->nextTransferDate?->getTimestamp());
    }
}
