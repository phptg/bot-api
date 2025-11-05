<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Animation;
use Phptg\BotApi\Type\PhotoSize;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class AnimationTest extends TestCase
{
    public function testBase(): void
    {
        $animation = new Animation('fileId', 'fileUniqueId', 100, 200, 48);

        assertSame('fileId', $animation->fileId);
        assertSame('fileUniqueId', $animation->fileUniqueId);
        assertSame(100, $animation->width);
        assertSame(200, $animation->height);
        assertSame(48, $animation->duration);
        assertNull($animation->thumbnail);
        assertNull($animation->fileName);
        assertNull($animation->mimeType);
        assertNull($animation->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $animation = (new ObjectFactory())->create([
            'file_id' => 'fileId',
            'file_unique_id' => 'fileUniqueId',
            'width' => 100,
            'height' => 200,
            'duration' => 48,
            'thumbnail' => [
                'file_id' => 'thumbFileId',
                'file_unique_id' => 'thumbFileUniqueId',
                'width' => 50,
                'height' => 72,
            ],
            'file_name' => 'face.gif',
            'mime_type' => 'image/gif',
            'file_size' => 512,
        ], null, Animation::class);

        assertInstanceOf(Animation::class, $animation);
        assertSame('fileId', $animation->fileId);
        assertSame('fileUniqueId', $animation->fileUniqueId);
        assertSame(100, $animation->width);
        assertSame(200, $animation->height);
        assertSame(48, $animation->duration);
        assertEquals(new PhotoSize('thumbFileId', 'thumbFileUniqueId', 50, 72), $animation->thumbnail);
        assertSame('face.gif', $animation->fileName);
        assertSame('image/gif', $animation->mimeType);
        assertSame(512, $animation->fileSize);
    }
}
