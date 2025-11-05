<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaAnimation;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaAnimationTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaAnimation('https://example.com/anime.gif');

        assertSame('animation', $inputMedia->getType());
        assertSame(
            [
                'type' => 'animation',
                'media' => 'https://example.com/anime.gif',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'animation',
                'media' => 'https://example.com/anime.gif',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $thumbnail = new InputFile((new StreamFactory())->createStream());
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaAnimation(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            true,
            240,
            320,
            23,
            false,
        );

        assertSame('animation', $inputMedia->getType());
        assertSame(
            [
                'type' => 'animation',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'width' => 240,
                'height' => 320,
                'duration' => 23,
                'has_spoiler' => false,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'animation',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'width' => 240,
                'height' => 320,
                'duration' => 23,
                'has_spoiler' => false,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $media,
                'file1' => $thumbnail,
            ],
            $fileCollector->get(),
        );
    }
}
