<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GiftBackground;
use Phptg\BotApi\Type\Sticker\Gift;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class GiftTest extends TestCase
{
    public function testBase(): void
    {
        $sticker = new Sticker(
            'x1',
            'fullX1',
            'regular',
            100,
            120,
            false,
            true,
        );
        $object = new Gift(
            'test-id',
            $sticker,
            12,
        );

        assertSame('test-id', $object->id);
        assertSame($sticker, $object->sticker);
        assertSame(12, $object->starCount);
        assertNull($object->upgradeStarCount);
        assertNull($object->isPremium);
        assertNull($object->hasColors);
        assertNull($object->totalCount);
        assertNull($object->remainingCount);
        assertNull($object->personalTotalCount);
        assertNull($object->personalRemainingCount);
        assertNull($object->background);
        assertNull($object->uniqueGiftVariantCount);
        assertNull($object->publisherChat);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'id' => 'test-id',
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
            'upgrade_star_count' => 53,
            'is_premium' => true,
            'has_colors' => true,
            'total_count' => 200,
            'remaining_count' => 30,
            'personal_total_count' => 150,
            'personal_remaining_count' => 25,
            'background' => [
                'center_color' => 16733525,
                'edge_color' => 13041721,
                'text_color' => 16777215,
            ],
            'unique_gift_variant_count' => 100,
            'publisher_chat' => [
                'id' => 456,
                'type' => 'channel',
            ],
        ], null, Gift::class);

        assertSame('test-id', $object->id);
        assertSame('x1', $object->sticker->fileId);
        assertSame(11, $object->starCount);
        assertSame(53, $object->upgradeStarCount);
        assertSame(true, $object->isPremium);
        assertSame(true, $object->hasColors);
        assertSame(200, $object->totalCount);
        assertSame(30, $object->remainingCount);
        assertSame(150, $object->personalTotalCount);
        assertSame(25, $object->personalRemainingCount);
        assertInstanceOf(GiftBackground::class, $object->background);
        assertSame(16733525, $object->background->centerColor);
        assertSame(13041721, $object->background->edgeColor);
        assertSame(16777215, $object->background->textColor);
        assertSame(100, $object->uniqueGiftVariantCount);
        assertSame(456, $object->publisherChat?->id);
    }
}
