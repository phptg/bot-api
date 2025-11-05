<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaAudio;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaAudioTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaAudio('https://example.com/start.mp3');

        assertSame('audio', $inputMedia->getType());
        assertSame(
            [
                'type' => 'audio',
                'media' => 'https://example.com/start.mp3',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'audio',
                'media' => 'https://example.com/start.mp3',
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
        $inputMedia = new InputMediaAudio(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            15,
            'The performer',
            'The title',
        );

        assertSame('audio', $inputMedia->getType());
        assertSame(
            [
                'type' => 'audio',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 15,
                'performer' => 'The performer',
                'title' => 'The title',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'audio',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 15,
                'performer' => 'The performer',
                'title' => 'The title',
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
