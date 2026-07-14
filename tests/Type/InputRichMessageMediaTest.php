<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichMessageMedia;

use function PHPUnit\Framework\assertSame;

final class InputRichMessageMediaTest extends TestCase
{
    public function testBase(): void
    {
        $media = new InputRichMessageMedia(
            'photo1',
            new InputMediaPhoto('photo_file_id_1'),
        );

        assertSame(
            [
                'id' => 'photo1',
                'media' => [
                    'type' => 'photo',
                    'media' => 'photo_file_id_1',
                ],
            ],
            $media->toRequestArray(),
        );
    }

    public function testWithFileCollector(): void
    {
        $file = new InputFile(null);
        $media = new InputRichMessageMedia(
            'photo1',
            new InputMediaPhoto($file),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'id' => 'photo1',
                'media' => [
                    'type' => 'photo',
                    'media' => 'attach://file0',
                ],
            ],
            $media->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
