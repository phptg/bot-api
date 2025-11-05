<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputPaidMediaPhoto;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputPaidMediaPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputPaidMediaPhoto('https://example.com/start.png');

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
        $inputMedia = new InputPaidMediaPhoto($media);

        assertSame('photo', $inputMedia->getType());
        assertSame(
            [
                'type' => 'photo',
                'media' => $media,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'photo',
                'media' => 'attach://file0',
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
