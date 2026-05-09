<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\LivePhoto;
use Phptg\BotApi\Type\PaidMediaLivePhoto;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PaidMediaLivePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $livePhoto = new LivePhoto('fileId', 'fileUniqueId', 640, 480, 3);
        $type = new PaidMediaLivePhoto($livePhoto);

        assertSame('live_photo', $type->getType());
        assertSame($livePhoto, $type->livePhoto);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'live_photo',
            'live_photo' => [
                'file_id' => 'fileId',
                'file_unique_id' => 'fileUniqueId',
                'width' => 640,
                'height' => 480,
                'duration' => 3,
            ],
        ], null, PaidMediaLivePhoto::class);

        assertSame('live_photo', $type->getType());
        assertInstanceOf(LivePhoto::class, $type->livePhoto);
        assertSame('fileId', $type->livePhoto->fileId);
        assertSame('fileUniqueId', $type->livePhoto->fileUniqueId);
        assertSame(640, $type->livePhoto->width);
        assertSame(480, $type->livePhoto->height);
        assertSame(3, $type->livePhoto->duration);
    }
}
