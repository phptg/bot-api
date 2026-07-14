<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockListItem;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputRichBlockListItemTest extends TestCase
{
    public function testBase(): void
    {
        $item = new InputRichBlockListItem([new InputRichBlockParagraph('hello')]);

        assertSame(
            ['blocks' => [['type' => 'paragraph', 'text' => 'hello']]],
            $item->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $item = new InputRichBlockListItem(
            [new InputRichBlockParagraph('hello')],
            true,
            true,
            3,
            'a',
        );

        assertTrue($item->hasCheckbox);
        assertTrue($item->isChecked);
        assertSame(3, $item->value);
        assertSame('a', $item->type);
        assertSame(
            [
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
                'has_checkbox' => true,
                'is_checked' => true,
                'value' => 3,
                'type' => 'a',
            ],
            $item->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToBlocks(): void
    {
        $file = new InputFile(null);
        $item = new InputRichBlockListItem([new InputRichBlockPhoto(new InputMediaPhoto($file))]);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
            ],
            $item->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
