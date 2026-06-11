<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Video;
use Phptg\BotApi\Type\RichBlockVideo;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RichBlockVideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new Video('f123', 'fullF123', 640, 480, 60);
        $block = new RichBlockVideo($video);

        assertSame('video', $block->getType());
        assertSame($video, $block->video);
        assertNull($block->hasSpoiler);
        assertNull($block->caption);
    }

    public function testFull(): void
    {
        $video = new Video('f123', 'fullF123', 640, 480, 60);
        $caption = new RichBlockCaption('video');
        $block = new RichBlockVideo($video, true, $caption);

        assertSame('video', $block->getType());
        assertTrue($block->hasSpoiler);
        assertSame($caption, $block->caption);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'video',
            'video' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'width' => 640,
                'height' => 480,
                'duration' => 60,
            ],
        ], null, RichBlockVideo::class);

        assertSame('video', $block->getType());
        assertInstanceOf(Video::class, $block->video);
        assertNull($block->hasSpoiler);
        assertNull($block->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'video',
            'video' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'width' => 640,
                'height' => 480,
                'duration' => 60,
            ],
            'has_spoiler' => true,
            'caption' => ['text' => 'video'],
        ], null, RichBlockVideo::class);

        assertSame('video', $block->getType());
        assertInstanceOf(Video::class, $block->video);
        assertTrue($block->hasSpoiler);
        assertInstanceOf(RichBlockCaption::class, $block->caption);
    }
}
