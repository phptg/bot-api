<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Sticker\StickerSet;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class StickerSetTest extends TestCase
{
    public function testBase(): void
    {
        $set = new StickerSet('test_by_bot', 'test', 'regular', []);

        assertSame('test_by_bot', $set->name);
        assertSame('test', $set->title);
        assertSame('regular', $set->stickerType);
        assertSame([], $set->stickers);
    }

    public function testFromTelegramResult(): void
    {
        $set = (new ObjectFactory())->create([
            'name' => 'test_by_bot',
            'title' => 'test',
            'sticker_type' => 'regular',
            'stickers' => [
                [
                    'file_id' => 'fid1',
                    'file_unique_id' => 'fuid1',
                    'type' => 'regular',
                    'width' => 200,
                    'height' => 300,
                    'is_animated' => false,
                    'is_video' => false,
                ],
            ],
            'thumbnail' => [
                'file_id' => 'tf1',
                'file_unique_id' => 'tfu1',
                'width' => 1,
                'height' => 2,
            ],
        ], null, StickerSet::class);

        assertSame('test_by_bot', $set->name);
        assertSame('test', $set->title);
        assertSame('regular', $set->stickerType);
        assertCount(1, $set->stickers);
        assertSame('fid1', $set->stickers[0]->fileId);
        assertSame('tf1', $set->thumbnail->fileId);
    }
}
