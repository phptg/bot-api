<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\LivePhoto;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class LivePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $livePhoto = new LivePhoto(
            fileId: 'file_id_123',
            fileUniqueId: 'file_unique_id_456',
            width: 1280,
            height: 720,
            duration: 5,
        );

        assertSame('file_id_123', $livePhoto->fileId);
        assertSame('file_unique_id_456', $livePhoto->fileUniqueId);
        assertSame(1280, $livePhoto->width);
        assertSame(720, $livePhoto->height);
        assertSame(5, $livePhoto->duration);
        assertNull($livePhoto->photo);
        assertNull($livePhoto->mimeType);
        assertNull($livePhoto->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $livePhoto = (new ObjectFactory())->create([
            'file_id' => 'file_id_abc',
            'file_unique_id' => 'file_unique_id_def',
            'width' => 1920,
            'height' => 1080,
            'duration' => 10,
            'photo' => [
                [
                    'file_id' => 'photo_file_id_1',
                    'file_unique_id' => 'photo_unique_id_1',
                    'width' => 1920,
                    'height' => 1080,
                ],
                [
                    'file_id' => 'photo_file_id_2',
                    'file_unique_id' => 'photo_unique_id_2',
                    'width' => 960,
                    'height' => 540,
                ],
            ],
            'mime_type' => 'video/mp4',
            'file_size' => 2097152,
        ], null, LivePhoto::class);

        assertSame('file_id_abc', $livePhoto->fileId);
        assertSame('file_unique_id_def', $livePhoto->fileUniqueId);
        assertSame(1920, $livePhoto->width);
        assertSame(1080, $livePhoto->height);
        assertSame(10, $livePhoto->duration);
        assertCount(2, $livePhoto->photo);
        assertSame('photo_file_id_1', $livePhoto->photo[0]->fileId);
        assertSame('photo_file_id_2', $livePhoto->photo[1]->fileId);
        assertSame('video/mp4', $livePhoto->mimeType);
        assertSame(2097152, $livePhoto->fileSize);
    }
}
