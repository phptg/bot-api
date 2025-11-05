<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Video;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class VideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new Video('f12', 'fu12', 100, 200, 23);

        assertSame('f12', $video->fileId);
        assertSame('fu12', $video->fileUniqueId);
        assertSame(100, $video->width);
        assertSame(200, $video->height);
        assertSame(23, $video->duration);
        assertNull($video->thumbnail);
        assertNull($video->fileName);
        assertNull($video->mimeType);
        assertNull($video->fileSize);
        assertNull($video->cover);
        assertNull($video->startTimestamp);
    }

    public function testFromTelegramResult(): void
    {
        $video = (new ObjectFactory())->create([
            'file_id' => 'f12',
            'file_unique_id' => 'fu12',
            'width' => 100,
            'height' => 200,
            'duration' => 23,
            'thumbnail' => [
                'file_id' => 'file_id-124',
                'file_unique_id' => 'file_unique_id',
                'width' => 500,
                'height' => 600,
            ],
            'cover' => [
                [
                    'file_id' => 'file_id-3',
                    'file_unique_id' => 'file_unique_id',
                    'width' => 150,
                    'height' => 150,
                ],
                [
                    'file_id' => 'file_id-4',
                    'file_unique_id' => 'file_unique_id',
                    'width' => 150,
                    'height' => 150,
                ],
            ],
            'start_timestamp' => 17,
            'file_name' => 'face.png',
            'mime_type' => 'image/png',
            'file_size' => 123,
        ], null, Video::class);

        assertSame('f12', $video->fileId);
        assertSame('fu12', $video->fileUniqueId);
        assertSame(100, $video->width);
        assertSame(200, $video->height);
        assertSame(23, $video->duration);
        assertSame('file_id-124', $video->thumbnail?->fileId);
        assertSame('face.png', $video->fileName);
        assertSame('image/png', $video->mimeType);
        assertSame(123, $video->fileSize);
        assertCount(2, $video->cover);
        assertSame('file_id-3', $video->cover[0]->fileId);
        assertSame('file_id-4', $video->cover[1]->fileId);
        assertSame(17, $video->startTimestamp);
    }
}
