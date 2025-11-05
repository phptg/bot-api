<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMediaVideo;
use Phptg\BotApi\Type\Video;

use function PHPUnit\Framework\assertSame;

final class PaidMediaVideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new Video('fileId', 'fileUniqueId', 100, 200, 12);
        $type = new PaidMediaVideo($video);

        assertSame('video', $type->getType());
        assertSame($video, $type->video);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'video',
            'video' => [
                'file_id' => 'f12',
                'file_unique_id' => 'fu12',
                'width' => 100,
                'height' => 200,
                'duration' => 23,
            ],
        ], null, PaidMediaVideo::class);

        assertSame('video', $type->getType());
        assertSame('f12', $type->video->fileId);
        assertSame('fu12', $type->video->fileUniqueId);
        assertSame(100, $type->video->width);
        assertSame(200, $type->video->height);
        assertSame(23, $type->video->duration);
    }
}
