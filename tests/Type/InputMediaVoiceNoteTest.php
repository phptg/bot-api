<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaVoiceNote;
use Phptg\BotApi\Type\MessageEntity;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaVoiceNoteTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaVoiceNote('https://example.com/voice.ogg');

        assertSame('voice_note', $inputMedia->getType());
        assertSame(
            [
                'type' => 'voice_note',
                'media' => 'https://example.com/voice.ogg',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'voice_note',
                'media' => 'https://example.com/voice.ogg',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile(null);
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaVoiceNote(
            $media,
            'Hello',
            'HTML',
            [$entity],
            15,
        );

        assertSame('voice_note', $inputMedia->getType());
        assertSame(
            [
                'type' => 'voice_note',
                'media' => $media,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 15,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'voice_note',
                'media' => 'attach://file0',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 15,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $media], $fileCollector->get());
    }
}
