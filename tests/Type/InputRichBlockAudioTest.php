<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaAudio;
use Phptg\BotApi\Type\InputRichBlockAudio;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockAudioTest extends TestCase
{
    public function testBase(): void
    {
        $audio = new InputRichBlockAudio(new InputMediaAudio('audio_file_id_1'));

        assertSame('audio', $audio->getType());
        assertSame(
            ['type' => 'audio', 'audio' => ['type' => 'audio', 'media' => 'audio_file_id_1']],
            $audio->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $audio = new InputRichBlockAudio(
            new InputMediaAudio('audio_file_id_1'),
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'audio',
                'audio' => ['type' => 'audio', 'media' => 'audio_file_id_1'],
                'caption' => ['text' => 'caption'],
            ],
            $audio->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagated(): void
    {
        $file = new InputFile(null);
        $audio = new InputRichBlockAudio(new InputMediaAudio($file));

        $fileCollector = new FileCollector();
        assertSame(
            ['type' => 'audio', 'audio' => ['type' => 'audio', 'media' => 'attach://file0']],
            $audio->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
