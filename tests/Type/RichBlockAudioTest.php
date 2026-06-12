<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Audio;
use Phptg\BotApi\Type\RichBlockAudio;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockAudioTest extends TestCase
{
    public function testBase(): void
    {
        $audio = new Audio('f123', 'fullF123', 180);
        $block = new RichBlockAudio($audio);

        assertSame('audio', $block->getType());
        assertSame($audio, $block->audio);
        assertNull($block->caption);
    }

    public function testFull(): void
    {
        $audio = new Audio('f123', 'fullF123', 180);
        $caption = new RichBlockCaption('audio');
        $block = new RichBlockAudio($audio, $caption);

        assertSame('audio', $block->getType());
        assertSame($caption, $block->caption);
    }

    public function testFromTelegramResult(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'audio',
            'audio' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'duration' => 180,
            ],
        ], null, RichBlockAudio::class);

        assertSame('audio', $block->getType());
        assertInstanceOf(Audio::class, $block->audio);
        assertNull($block->caption);
    }

    public function testFromTelegramResultFull(): void
    {
        $block = (new ObjectFactory())->create([
            'type' => 'audio',
            'audio' => [
                'file_id' => 'f123',
                'file_unique_id' => 'fullF123',
                'duration' => 180,
            ],
            'caption' => ['text' => 'audio'],
        ], null, RichBlockAudio::class);

        assertSame('audio', $block->getType());
        assertInstanceOf(Audio::class, $block->audio);
        assertInstanceOf(RichBlockCaption::class, $block->caption);
    }
}
