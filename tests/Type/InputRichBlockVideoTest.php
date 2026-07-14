<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaVideo;
use Phptg\BotApi\Type\InputRichBlockVideo;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockVideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new InputRichBlockVideo(new InputMediaVideo('https://example.com/a.mp4'));

        assertSame('video', $video->getType());
        assertSame(
            ['type' => 'video', 'video' => ['type' => 'video', 'media' => 'https://example.com/a.mp4']],
            $video->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $video = new InputRichBlockVideo(
            new InputMediaVideo('https://example.com/a.mp4'),
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'video',
                'video' => ['type' => 'video', 'media' => 'https://example.com/a.mp4'],
                'caption' => ['text' => 'caption'],
            ],
            $video->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagated(): void
    {
        $file = new InputFile(null);
        $video = new InputRichBlockVideo(new InputMediaVideo($file));

        $fileCollector = new FileCollector();
        assertSame(
            ['type' => 'video', 'video' => ['type' => 'video', 'media' => 'attach://file0']],
            $video->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
