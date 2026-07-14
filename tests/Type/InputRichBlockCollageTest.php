<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockCollage;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;
use Phptg\BotApi\Type\RichBlockCaption;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockCollageTest extends TestCase
{
    public function testBase(): void
    {
        $collage = new InputRichBlockCollage([new InputRichBlockParagraph('hello')]);

        assertSame('collage', $collage->getType());
        assertSame(
            ['type' => 'collage', 'blocks' => [['type' => 'paragraph', 'text' => 'hello']]],
            $collage->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $collage = new InputRichBlockCollage(
            [new InputRichBlockParagraph('hello')],
            new RichBlockCaption('caption'),
        );

        assertSame(
            [
                'type' => 'collage',
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
                'caption' => ['text' => 'caption'],
            ],
            $collage->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToBlocks(): void
    {
        $file = new InputFile(null);
        $collage = new InputRichBlockCollage([new InputRichBlockPhoto(new InputMediaPhoto($file))]);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'collage',
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
            ],
            $collage->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
