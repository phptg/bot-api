<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GiftInfo;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\Sticker\Gift;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class GiftInfoTest extends TestCase
{
    public function testBase(): void
    {
        $gift = new Gift(
            'g1',
            new Sticker(
                'x1',
                'fullX1',
                'regular',
                100,
                120,
                false,
                true,
            ),
            12,
        );
        $giftInfo = new GiftInfo($gift);

        assertSame($gift, $giftInfo->gift);
        assertNull($giftInfo->ownedGiftId);
        assertNull($giftInfo->convertStarCount);
        assertNull($giftInfo->prepaidUpgradeStarCount);
        assertNull($giftInfo->canBeUpgraded);
        assertNull($giftInfo->text);
        assertNull($giftInfo->entities);
        assertNull($giftInfo->isPrivate);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
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
            'owned_gift_id' => 'ogid1',
            'convert_star_count' => 10,
            'prepaid_upgrade_star_count' => 5,
            'can_be_upgraded' => true,
            'text' => 'Happy Birthday!',
            'entities' => [
                [
                    'type' => 'bold',
                    'offset' => 0,
                    'length' => 5,
                ],
            ],
            'is_private' => true,
        ], null, GiftInfo::class);

        assertInstanceOf(GiftInfo::class, $type);
        assertInstanceOf(Gift::class, $type->gift);
        assertSame('ogid1', $type->ownedGiftId);
        assertSame(10, $type->convertStarCount);
        assertSame(5, $type->prepaidUpgradeStarCount);
        assertTrue($type->canBeUpgraded);
        assertSame('Happy Birthday!', $type->text);
        assertInstanceOf(MessageEntity::class, $type->entities[0]);
        assertSame('bold', $type->entities[0]->type);
        assertSame(0, $type->entities[0]->offset);
        assertSame(5, $type->entities[0]->length);
        assertTrue($type->isPrivate);
    }
}
