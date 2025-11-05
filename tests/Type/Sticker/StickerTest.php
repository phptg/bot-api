<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\File;
use Phptg\BotApi\Type\PhotoSize;
use Phptg\BotApi\Type\Sticker\MaskPosition;
use Phptg\BotApi\Type\Sticker\Sticker;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class StickerTest extends TestCase
{
    public function testSticker(): void
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

        assertSame('x1', $sticker->fileId);
        assertSame('fullX1', $sticker->fileUniqueId);
        assertSame('regular', $sticker->type);
        assertSame(100, $sticker->width);
        assertSame(120, $sticker->height);
        assertFalse($sticker->isAnimated);
        assertTrue($sticker->isVideo);
        assertNull($sticker->thumbnail);
        assertNull($sticker->emoji);
        assertNull($sticker->setName);
        assertNull($sticker->premiumAnimation);
        assertNull($sticker->maskPosition);
        assertNull($sticker->customEmojiId);
        assertNull($sticker->needsRepainting);
        assertNull($sticker->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $sticker = (new ObjectFactory())->create([
            'file_id' => 'x1',
            'file_unique_id' => 'fullX1',
            'type' => 'regular',
            'width' => 100,
            'height' => 120,
            'is_animated' => false,
            'is_video' => true,
            'thumbnail' => [
                'file_id' => 'x2',
                'file_unique_id' => 'fullX2',
                'width' => 200,
                'height' => 240,
            ],
            'emoji' => '😀',
            'set_name' => 'hello-name',
            'premium_animation' => [
                'file_id' => 'x3',
                'file_unique_id' => 'fullX3',
                'width' => 300,
                'height' => 360,
            ],
            'mask_position' => [
                'point' => 'forehead',
                'x_shift' => 1.1,
                'y_shift' => 2.2,
                'scale' => 3.3,
            ],
            'custom_emoji_id' => 'customEmojiId',
            'needs_repainting' => true,
            'file_size' => 123,
        ], null, Sticker::class);

        assertSame('x1', $sticker->fileId);
        assertSame('fullX1', $sticker->fileUniqueId);
        assertSame('regular', $sticker->type);
        assertSame(100, $sticker->width);
        assertSame(120, $sticker->height);
        assertFalse($sticker->isAnimated);
        assertTrue($sticker->isVideo);

        assertInstanceOf(PhotoSize::class, $sticker->thumbnail);
        assertSame('x2', $sticker->thumbnail->fileId);

        assertSame('😀', $sticker->emoji);
        assertSame('hello-name', $sticker->setName);

        assertInstanceOf(File::class, $sticker->premiumAnimation);
        assertSame('x3', $sticker->premiumAnimation->fileId);

        assertInstanceOf(MaskPosition::class, $sticker->maskPosition);
        assertSame('forehead', $sticker->maskPosition->point);

        assertSame('customEmojiId', $sticker->customEmojiId);
        assertTrue($sticker->needsRepainting);
        assertSame(123, $sticker->fileSize);
    }
}
