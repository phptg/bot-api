<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\OwnedGiftRegular;
use Phptg\BotApi\Type\Sticker\Gift;
use Phptg\BotApi\Type\Sticker\Sticker;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class OwnedGiftRegularTest extends TestCase
{
    public function testBase(): void
    {
        $gift = new Gift(
            'gift1',
            new Sticker(
                'x1',
                'fullX1',
                'regular',
                100,
                120,
                false,
                true,
            ),
            90,
        );
        $sendDate = new DateTimeImmutable();
        $type = new OwnedGiftRegular($gift, $sendDate);

        assertSame('regular', $type->getType());
        assertSame($gift, $type->gift);
        assertSame($sendDate, $type->sendDate);
        assertNull($type->ownedGiftId);
        assertNull($type->senderUser);
        assertNull($type->text);
        assertNull($type->entities);
        assertNull($type->isPrivate);
        assertNull($type->isSaved);
        assertNull($type->canBeUpgraded);
        assertNull($type->wasRefunded);
        assertNull($type->convertStarCount);
        assertNull($type->prepaidUpgradeStarCount);
        assertNull($type->isUpgradeSeparate);
        assertNull($type->uniqueGiftNumber);
    }

    public function testFull(): void
    {
        $gift = new Gift(
            'gift1',
            new Sticker(
                'x1',
                'fullX1',
                'regular',
                100,
                120,
                false,
                true,
            ),
            90,
        );
        $sendDate = new DateTimeImmutable();
        $senderUser = new User(123, false, 'John');
        $entities = [new MessageEntity('bold', 0, 4)];
        $ownedGift = new OwnedGiftRegular(
            $gift,
            $sendDate,
            'ownedGiftId1',
            $senderUser,
            'Hello',
            $entities,
            true,
            true,
            true,
            true,
            10,
            5,
            true,
            42,
        );

        assertSame($gift, $ownedGift->gift);
        assertSame($sendDate, $ownedGift->sendDate);
        assertSame('ownedGiftId1', $ownedGift->ownedGiftId);
        assertSame($senderUser, $ownedGift->senderUser);
        assertSame('Hello', $ownedGift->text);
        assertSame($entities, $ownedGift->entities);
        assertTrue($ownedGift->isPrivate);
        assertTrue($ownedGift->isSaved);
        assertTrue($ownedGift->canBeUpgraded);
        assertTrue($ownedGift->wasRefunded);
        assertSame(10, $ownedGift->convertStarCount);
        assertSame(5, $ownedGift->prepaidUpgradeStarCount);
        assertTrue($ownedGift->isUpgradeSeparate);
        assertSame(42, $ownedGift->uniqueGiftNumber);
    }

    public function testFromTelegramResult(): void
    {
        $ownedGift = (new ObjectFactory())->create([
            'gift' => [
                'id' => 'test-id1',
                'sticker' => [
                    'file_id' => 'x1',
                    'file_unique_id' => 'fullX1',
                    'type' => 'regular',
                    'width' => 100,
                    'height' => 120,
                    'is_animated' => false,
                    'is_video' => true,
                ],
                'star_count' => 11,
            ],
            'owned_gift_id' => 'ownedGiftId1',
            'sender_user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'send_date' => 1619040000,
            'text' => 'Hello',
            'entities' => [
                [
                    'type' => 'bold',
                    'offset' => 0,
                    'length' => 4,
                ],
            ],
            'is_private' => true,
            'is_saved' => true,
            'can_be_upgraded' => true,
            'was_refunded' => true,
            'convert_star_count' => 10,
            'prepaid_upgrade_star_count' => 5,
            'is_upgrade_separate' => true,
            'unique_gift_number' => 42,
        ], null, OwnedGiftRegular::class);

        assertInstanceOf(OwnedGiftRegular::class, $ownedGift);

        assertInstanceOf(Gift::class, $ownedGift->gift);

        assertEquals(new DateTimeImmutable('@1619040000'), $ownedGift->sendDate);
        assertSame('ownedGiftId1', $ownedGift->ownedGiftId);

        assertInstanceOf(User::class, $ownedGift->senderUser);
        assertSame(123, $ownedGift->senderUser->id);
        assertFalse($ownedGift->senderUser->isBot);
        assertSame('John', $ownedGift->senderUser->firstName);

        assertSame('Hello', $ownedGift->text);
        assertInstanceOf(MessageEntity::class, $ownedGift->entities[0]);
        assertSame('bold', $ownedGift->entities[0]->type);
        assertSame(0, $ownedGift->entities[0]->offset);
        assertSame(4, $ownedGift->entities[0]->length);

        assertTrue($ownedGift->isPrivate);
        assertTrue($ownedGift->isSaved);
        assertTrue($ownedGift->canBeUpgraded);
        assertTrue($ownedGift->wasRefunded);
        assertSame(10, $ownedGift->convertStarCount);
        assertSame(5, $ownedGift->prepaidUpgradeStarCount);
        assertTrue($ownedGift->isUpgradeSeparate);
        assertSame(42, $ownedGift->uniqueGiftNumber);
    }
}
