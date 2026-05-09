<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaLivePhoto;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaLivePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaLivePhoto(
            'https://example.com/video.mp4',
            'https://example.com/photo.jpg',
        );

        assertSame('live_photo', $inputMedia->getType());
        assertSame(
            [
                'type' => 'live_photo',
                'media' => 'https://example.com/video.mp4',
                'photo' => 'https://example.com/photo.jpg',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'live_photo',
                'media' => 'https://example.com/video.mp4',
                'photo' => 'https://example.com/photo.jpg',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $mediaFile = new InputFile(null);
        $photoFile = new InputFile(null);
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaLivePhoto(
            $mediaFile,
            $photoFile,
            'Hello',
            'HTML',
            [$entity],
            false,
            true,
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'live_photo',
                'media' => 'attach://file0',
                'photo' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'has_spoiler' => true,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $mediaFile,
                'file1' => $photoFile,
            ],
            $fileCollector->get(),
        );
    }
}
