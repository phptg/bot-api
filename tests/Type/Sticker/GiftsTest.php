<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\Gifts;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class GiftsTest extends TestCase
{
    public function testBase(): void
    {
        $object = new Gifts([]);

        assertSame([], $object->gifts);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'gifts' => [
                [
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
                [
                    'id' => 'test-id2',
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
            ],
        ], null, Gifts::class);

        assertCount(2, $object->gifts);
        assertSame('test-id1', $object->gifts[0]->id);
        assertSame('test-id2', $object->gifts[1]->id);
    }
}
