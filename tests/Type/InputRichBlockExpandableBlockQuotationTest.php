<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockExpandableBlockQuotation;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockExpandableBlockQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $blockQuotation = new InputRichBlockExpandableBlockQuotation([new InputRichBlockParagraph('hello')]);

        assertSame('expandable_blockquote', $blockQuotation->getType());
        assertSame(
            ['type' => 'expandable_blockquote', 'blocks' => [['type' => 'paragraph', 'text' => 'hello']]],
            $blockQuotation->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $blockQuotation = new InputRichBlockExpandableBlockQuotation(
            [new InputRichBlockParagraph('hello')],
            'credit',
        );

        assertSame(
            [
                'type' => 'expandable_blockquote',
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
                'credit' => 'credit',
            ],
            $blockQuotation->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToBlocks(): void
    {
        $file = new InputFile('/path/to/file');
        $blockQuotation = new InputRichBlockExpandableBlockQuotation(
            [new InputRichBlockPhoto(new InputMediaPhoto($file))],
        );

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'expandable_blockquote',
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
            ],
            $blockQuotation->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
