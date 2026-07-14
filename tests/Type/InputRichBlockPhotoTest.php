<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockPhoto;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputRichBlockPhoto(new InputMediaPhoto('https://example.com/a.jpg'));

        assertSame('photo', $photo->getType());
        assertSame(
            ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'https://example.com/a.jpg']],
            $photo->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $photo = new InputRichBlockPhoto(
            new InputMediaPhoto('https://example.com/a.jpg'),
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'photo',
                'photo' => ['type' => 'photo', 'media' => 'https://example.com/a.jpg'],
                'caption' => ['text' => 'caption'],
            ],
            $photo->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagated(): void
    {
        $file = new InputFile(null);
        $photo = new InputRichBlockPhoto(new InputMediaPhoto($file));

        $fileCollector = new FileCollector();
        assertSame(
            ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
            $photo->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
