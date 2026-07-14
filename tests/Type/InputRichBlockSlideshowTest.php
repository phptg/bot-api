<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;
use Phptg\BotApi\Type\InputRichBlockSlideshow;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockSlideshowTest extends TestCase
{
    public function testBase(): void
    {
        $slideshow = new InputRichBlockSlideshow([new InputRichBlockParagraph('hello')]);

        assertSame('slideshow', $slideshow->getType());
        assertSame(
            ['type' => 'slideshow', 'blocks' => [['type' => 'paragraph', 'text' => 'hello']]],
            $slideshow->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $slideshow = new InputRichBlockSlideshow(
            [new InputRichBlockParagraph('hello')],
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'slideshow',
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
                'caption' => ['text' => 'caption'],
            ],
            $slideshow->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToBlocks(): void
    {
        $file = new InputFile(null);
        $slideshow = new InputRichBlockSlideshow([new InputRichBlockPhoto(new InputMediaPhoto($file))]);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'slideshow',
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
            ],
            $slideshow->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
