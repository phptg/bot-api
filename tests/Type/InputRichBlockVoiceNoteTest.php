<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaVoiceNote;
use Phptg\BotApi\Type\InputRichBlockVoiceNote;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockVoiceNoteTest extends TestCase
{
    public function testBase(): void
    {
        $voiceNote = new InputRichBlockVoiceNote(new InputMediaVoiceNote('https://example.com/a.ogg'));

        assertSame('voice_note', $voiceNote->getType());
        assertSame(
            [
                'type' => 'voice_note',
                'voice_note' => ['type' => 'voice_note', 'media' => 'https://example.com/a.ogg'],
            ],
            $voiceNote->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $voiceNote = new InputRichBlockVoiceNote(
            new InputMediaVoiceNote('https://example.com/a.ogg'),
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'voice_note',
                'voice_note' => ['type' => 'voice_note', 'media' => 'https://example.com/a.ogg'],
                'caption' => ['text' => 'caption'],
            ],
            $voiceNote->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagated(): void
    {
        $file = new InputFile(null);
        $voiceNote = new InputRichBlockVoiceNote(new InputMediaVoiceNote($file));

        $fileCollector = new FileCollector();
        assertSame(
            ['type' => 'voice_note', 'voice_note' => ['type' => 'voice_note', 'media' => 'attach://file0']],
            $voiceNote->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
