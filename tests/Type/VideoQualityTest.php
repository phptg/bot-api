<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\VideoQuality;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class VideoQualityTest extends TestCase
{
    public function testBase(): void
    {
        $videoQuality = new VideoQuality('fileId', 'fileUniqueId', 1920, 1080, 'h264');

        assertSame('fileId', $videoQuality->fileId);
        assertSame('fileUniqueId', $videoQuality->fileUniqueId);
        assertSame(1920, $videoQuality->width);
        assertSame(1080, $videoQuality->height);
        assertSame('h264', $videoQuality->codec);
        assertNull($videoQuality->fileSize);
    }

    public function testFull(): void
    {
        $videoQuality = new VideoQuality('fileId', 'fileUniqueId', 1920, 1080, 'h265', 4096);

        assertSame('fileId', $videoQuality->fileId);
        assertSame('fileUniqueId', $videoQuality->fileUniqueId);
        assertSame(1920, $videoQuality->width);
        assertSame(1080, $videoQuality->height);
        assertSame('h265', $videoQuality->codec);
        assertSame(4096, $videoQuality->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $videoQuality = (new ObjectFactory())->create([
            'file_id' => 'fileId',
            'file_unique_id' => 'fileUniqueId',
            'width' => 1920,
            'height' => 1080,
            'codec' => 'h265',
            'file_size' => 4096,
        ], null, VideoQuality::class);

        assertInstanceOf(VideoQuality::class, $videoQuality);
        assertSame('fileId', $videoQuality->fileId);
        assertSame('fileUniqueId', $videoQuality->fileUniqueId);
        assertSame(1920, $videoQuality->width);
        assertSame(1080, $videoQuality->height);
        assertSame('h265', $videoQuality->codec);
        assertSame(4096, $videoQuality->fileSize);
    }
}
