<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaVideo;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaVideoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaVideo('https://example.com/start.mp4');

        assertSame('video', $inputMedia->getType());
        assertSame(
            [
                'type' => 'video',
                'media' => 'https://example.com/start.mp4',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'video',
                'media' => 'https://example.com/start.mp4',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $thumbnail = new InputFile((new StreamFactory())->createStream());
        $cover = new InputFile((new StreamFactory())->createStream());
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaVideo(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            false,
            240,
            320,
            500,
            true,
            false,
            $cover,
            17,
        );

        assertSame('video', $inputMedia->getType());
        assertSame(
            [
                'type' => 'video',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'cover' => $cover,
                'start_timestamp' => 17,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'width' => 240,
                'height' => 320,
                'duration' => 500,
                'supports_streaming' => true,
                'has_spoiler' => false,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'video',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'cover' => 'attach://file2',
                'start_timestamp' => 17,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'width' => 240,
                'height' => 320,
                'duration' => 500,
                'supports_streaming' => true,
                'has_spoiler' => false,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $media,
                'file1' => $thumbnail,
                'file2' => $cover,
            ],
            $fileCollector->get(),
        );
    }
}
