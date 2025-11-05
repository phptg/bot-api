<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PhotoSize;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PhotoSizeTest extends TestCase
{
    public function testBase(): void
    {
        $photoSize = new PhotoSize('fileId', 'fileUniqueId', 100, 200);

        assertSame('fileId', $photoSize->fileId);
        assertSame('fileUniqueId', $photoSize->fileUniqueId);
        assertSame(100, $photoSize->width);
        assertSame(200, $photoSize->height);
        assertSame(null, $photoSize->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $photoSize = (new ObjectFactory())->create([
            'file_id' => 'fileId',
            'file_unique_id' => 'fileUniqueId',
            'width' => 100,
            'height' => 200,
            'file_size' => 512,
        ], null, PhotoSize::class);

        assertInstanceOf(PhotoSize::class, $photoSize);
        assertSame('fileId', $photoSize->fileId);
        assertSame('fileUniqueId', $photoSize->fileUniqueId);
        assertSame(100, $photoSize->width);
        assertSame(200, $photoSize->height);
        assertSame(512, $photoSize->fileSize);
    }
}
