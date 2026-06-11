<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PhotoSize;
use Phptg\BotApi\Type\RichBlockPhoto;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new PhotoSize('f123', 'fullF123', 640, 480);
        $block = new RichBlockPhoto([$photo]);

        assertSame('photo', $block->getType());
        assertCount(1, $block->photo);
        assertNull($block->hasSpoiler);
        assertNull($block->caption);
    }

    public function testFull(): void
    {
        $photo = new PhotoSize('f123', 'fullF123', 640, 480);
        $caption = new RichBlockCaption('photo');
        $block = new RichBlockPhoto([$photo], true, $caption);

        assertSame('photo', $block->getType());
        assertTrue($block->hasSpoiler);
        assertSame($caption, $block->caption);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'photo',
            'photo' => [
                ['file_id' => 'f123', 'file_unique_id' => 'fullF123', 'width' => 640, 'height' => 480],
                ['file_id' => 'f456', 'file_unique_id' => 'fullF456', 'width' => 320, 'height' => 240],
            ],
        ], null, RichBlockPhoto::class);

        assertSame('photo', $block->getType());
        assertCount(2, $block->photo);
        assertInstanceOf(PhotoSize::class, $block->photo[0]);
        assertInstanceOf(PhotoSize::class, $block->photo[1]);
        assertNull($block->hasSpoiler);
        assertNull($block->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'photo',
            'photo' => [
                ['file_id' => 'f123', 'file_unique_id' => 'fullF123', 'width' => 640, 'height' => 480],
            ],
            'has_spoiler' => true,
            'caption' => ['text' => 'photo'],
        ], null, RichBlockPhoto::class);

        assertSame('photo', $block->getType());
        assertCount(1, $block->photo);
        assertTrue($block->hasSpoiler);
        assertInstanceOf(RichBlockCaption::class, $block->caption);
    }
}
