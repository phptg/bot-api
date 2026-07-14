<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockBlockQuotation;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockBlockQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $blockQuotation = new InputRichBlockBlockQuotation([new InputRichBlockParagraph('hello')]);

        assertSame('blockquote', $blockQuotation->getType());
        assertSame(
            ['type' => 'blockquote', 'blocks' => [['type' => 'paragraph', 'text' => 'hello']]],
            $blockQuotation->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $blockQuotation = new InputRichBlockBlockQuotation([new InputRichBlockParagraph('hello')], 'credit');

        assertSame(
            [
                'type' => 'blockquote',
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
                'credit' => 'credit',
            ],
            $blockQuotation->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToBlocks(): void
    {
        $file = new InputFile(null);
        $blockQuotation = new InputRichBlockBlockQuotation([new InputRichBlockPhoto(new InputMediaPhoto($file))]);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'blockquote',
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
            ],
            $blockQuotation->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
