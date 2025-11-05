<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputPaidMediaVideo;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputPaidMediaVideoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputPaidMediaVideo('https://example.com/start.mp4');

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
        $inputMedia = new InputPaidMediaVideo(
            $media,
            $thumbnail,
            240,
            320,
            500,
            true,
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
                'width' => 240,
                'height' => 320,
                'duration' => 500,
                'supports_streaming' => true,
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
                'width' => 240,
                'height' => 320,
                'duration' => 500,
                'supports_streaming' => true,
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
