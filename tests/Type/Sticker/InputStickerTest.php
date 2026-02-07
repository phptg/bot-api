<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Sticker;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Constant\Sticker\StickerFormat;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\Sticker\InputSticker;
use Phptg\BotApi\Type\Sticker\MaskPosition;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertSame;

final class InputStickerTest extends TestCase
{
    public function testBase(): void
    {
        $inputSticker = new InputSticker(
            'https://example.com/emoji.png',
            'static',
            ['👍', '👎'],
        );

        assertSame(
            [
                'sticker' => 'https://example.com/emoji.png',
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
            ],
            $inputSticker->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'sticker' => 'https://example.com/emoji.png',
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
            ],
            $inputSticker->toRequestArray($fileCollector),
        );
        assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $file = new InputFile(null);
        $maskPosition = new MaskPosition('forehead', 0.5, 0.6, 0.7);
        $inputSticker = new InputSticker(
            $file,
            StickerFormat::STATIC,
            ['👍', '👎'],
            $maskPosition,
            ['test'],
        );

        assertSame(
            [
                'sticker' => $file,
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
                'mask_position' => $maskPosition->toRequestArray(),
                'keywords' => ['test'],
            ],
            $inputSticker->toRequestArray(),
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'sticker' => 'attach://file0',
                'format' => 'static',
                'emoji_list' => ['👍', '👎'],
                'mask_position' => $maskPosition->toRequestArray(),
                'keywords' => ['test'],
            ],
            $inputSticker->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $file,
            ],
            $fileCollector->get(),
        );
    }
}
