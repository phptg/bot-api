<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaPhoto('https://example.com/start.png');

        assertSame('photo', $inputMedia->getType());
        assertSame(
            [
                'type' => 'photo',
                'media' => 'https://example.com/start.png',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'photo',
                'media' => 'https://example.com/start.png',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaPhoto(
            $media,
            'Hello',
            'HTML',
            [$entity],
            false,
            true,
        );

        assertSame('photo', $inputMedia->getType());
        assertSame(
            [
                'type' => 'photo',
                'media' => $media,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'has_spoiler' => true,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'photo',
                'media' => 'attach://file0',
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
                'file0' => $media,
            ],
            $fileCollector->get(),
        );
    }
}
