<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Voice;
use Phptg\BotApi\Type\RichBlockVoiceNote;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockVoiceNoteTest extends TestCase
{
    public function testBase(): void
    {
        $voice = new Voice('f123', 'fullF123', 60);
        $block = new RichBlockVoiceNote($voice);

        assertSame('voice_note', $block->getType());
        assertSame($voice, $block->voiceNote);
        assertNull($block->caption);
    }

    public function testFull(): void
    {
        $voice = new Voice('f123', 'fullF123', 60);
        $caption = new RichBlockCaption('voice note');
        $block = new RichBlockVoiceNote($voice, $caption);

        assertSame('voice_note', $block->getType());
        assertSame($caption, $block->caption);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'voice_note',
            'voice_note' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'duration' => 60,
            ],
        ], null, RichBlockVoiceNote::class);

        assertSame('voice_note', $block->getType());
        assertInstanceOf(Voice::class, $block->voiceNote);
        assertNull($block->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'voice_note',
            'voice_note' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'duration' => 60,
            ],
            'caption' => ['text' => 'voice note'],
        ], null, RichBlockVoiceNote::class);

        assertSame('voice_note', $block->getType());
        assertInstanceOf(Voice::class, $block->voiceNote);
        assertInstanceOf(RichBlockCaption::class, $block->caption);
    }
}
