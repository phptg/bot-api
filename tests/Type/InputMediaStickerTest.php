<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaSticker;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputMediaStickerTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaSticker('https://example.com/sticker.webp');

        assertSame('sticker', $inputMedia->getType());
        assertSame(
            [
                'type' => 'sticker',
                'media' => 'https://example.com/sticker.webp',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'sticker',
                'media' => 'https://example.com/sticker.webp',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile(null);
        $inputMedia = new InputMediaSticker($media, '😀');
        $fileCollector = new FileCollector();

        assertSame('sticker', $inputMedia->getType());
        assertSame(
            [
                'type' => 'sticker',
                'media' => 'attach://file0',
                'emoji' => '😀',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $media], $fileCollector->get());
    }
}
