<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\OwnedGiftRegular;
use Phptg\BotApi\Type\OwnedGifts;
use Phptg\BotApi\Type\Sticker\Gift;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class OwnedGiftsTest extends TestCase
{
    public function testBase(): void
    {
        $gifts = [
            new OwnedGiftRegular(
                new Gift(
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
                ),
                new DateTimeImmutable(),
            ),
        ];
        $type = new OwnedGifts(1, $gifts);

        assertSame(1, $type->totalCount);
        assertSame($gifts, $type->gifts);
        assertNull($type->nextOffset);
    }

    public function testFull(): void
    {
        $gifts = [
            new OwnedGiftRegular(
                new Gift(
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
                ),
                new DateTimeImmutable(),
            ),
        ];
        $ownedGifts = new OwnedGifts(1, $gifts, 'next-offset');

        assertSame(1, $ownedGifts->totalCount);
        assertSame($gifts, $ownedGifts->gifts);
        assertSame('next-offset', $ownedGifts->nextOffset);
    }

    public function testFromTelegramResult(): void
    {
        $ownedGifts = (new ObjectFactory())->create([
            'total_count' => 1,
            'gifts' => [
                [
                    'type' => 'regular',
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
                    'send_date' => 1619040000,
                ],
            ],
            'next_offset' => 'next-offset',
        ], null, OwnedGifts::class);

        assertInstanceOf(OwnedGifts::class, $ownedGifts);
        assertSame(1, $ownedGifts->totalCount);
        assertCount(1, $ownedGifts->gifts);
        assertInstanceOf(OwnedGiftRegular::class, $ownedGifts->gifts[0]);
        assertSame('test-id1', $ownedGifts->gifts[0]->gift->id);
        assertSame('next-offset', $ownedGifts->nextOffset);
    }
}
