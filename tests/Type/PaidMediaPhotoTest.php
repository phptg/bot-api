<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMediaPhoto;
use Phptg\BotApi\Type\PhotoSize;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PaidMediaPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photoSize = new PhotoSize('fileId', 'fileUniqueId', 100, 200);
        $type = new PaidMediaPhoto([$photoSize]);

        assertSame('photo', $type->getType());
        assertSame([$photoSize], $type->photo);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'photo',
            'photo' => [
                [
                    'file_id' => 'fileId',
                    'file_unique_id' => 'fileUniqueId',
                    'width' => 100,
                    'height' => 200,
                    'file_size' => 512,
                ],
            ],
        ], null, PaidMediaPhoto::class);

        assertSame('photo', $type->getType());
        assertCount(1, $type->photo);
        assertInstanceOf(PhotoSize::class, $type->photo[0]);
        assertSame('fileId', $type->photo[0]->fileId);
        assertSame('fileUniqueId', $type->photo[0]->fileUniqueId);
        assertSame(100, $type->photo[0]->width);
        assertSame(200, $type->photo[0]->height);
        assertSame(512, $type->photo[0]->fileSize);
    }
}
