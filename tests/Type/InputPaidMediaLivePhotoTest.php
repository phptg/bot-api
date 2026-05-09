<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputPaidMediaLivePhoto;

use function PHPUnit\Framework\assertSame;

final class InputPaidMediaLivePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputPaidMediaLivePhoto('file_id_video', 'file_id_photo');

        assertSame('live_photo', $inputMedia->getType());
        assertSame(
            [
                'type' => 'live_photo',
                'media' => 'file_id_video',
                'photo' => 'file_id_photo',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'live_photo',
                'media' => 'file_id_video',
                'photo' => 'file_id_photo',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame([], $fileCollector->get());
    }

    public function testFull(): void
    {
        $mediaFile = new InputFile(null);
        $photoFile = new InputFile(null);
        $inputMedia = new InputPaidMediaLivePhoto($mediaFile, $photoFile);

        assertSame('live_photo', $inputMedia->getType());
        assertSame(
            [
                'type' => 'live_photo',
                'media' => $mediaFile,
                'photo' => $photoFile,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'live_photo',
                'media' => 'attach://file0',
                'photo' => 'attach://file1',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $mediaFile,
                'file1' => $photoFile,
            ],
            $fileCollector->get(),
        );
    }
}
