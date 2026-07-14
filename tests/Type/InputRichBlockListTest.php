<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockList;
use Phptg\BotApi\Type\InputRichBlockListItem;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockListTest extends TestCase
{
    public function testBase(): void
    {
        $item = new InputRichBlockListItem([new InputRichBlockParagraph('hello')]);
        $list = new InputRichBlockList([$item]);

        assertSame('list', $list->getType());
        assertSame(
            [
                'type' => 'list',
                'items' => [
                    ['blocks' => [['type' => 'paragraph', 'text' => 'hello']]],
                ],
            ],
            $list->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToItems(): void
    {
        $file = new InputFile(null);
        $item = new InputRichBlockListItem([new InputRichBlockPhoto(new InputMediaPhoto($file))]);
        $list = new InputRichBlockList([$item]);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'list',
                'items' => [
                    [
                        'blocks' => [
                            ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                        ],
                    ],
                ],
            ],
            $list->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
