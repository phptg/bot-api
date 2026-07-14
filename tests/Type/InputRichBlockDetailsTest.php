<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\FileCollector;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\Type\InputMediaPhoto;
use Phptg\BotApi\Type\InputRichBlockDetails;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\InputRichBlockPhoto;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockDetailsTest extends TestCase
{
    public function testBase(): void
    {
        $details = new InputRichBlockDetails('summary', [new InputRichBlockParagraph('hello')]);

        assertSame('details', $details->getType());
        assertSame(
            [
                'type' => 'details',
                'summary' => 'summary',
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
            ],
            $details->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $details = new InputRichBlockDetails('summary', [new InputRichBlockParagraph('hello')], true);

        assertSame(
            [
                'type' => 'details',
                'summary' => 'summary',
                'blocks' => [['type' => 'paragraph', 'text' => 'hello']],
                'is_open' => true,
            ],
            $details->toRequestArray(),
        );
    }

    public function testFileCollectorIsPropagatedToBlocks(): void
    {
        $file = new InputFile(null);
        $details = new InputRichBlockDetails('summary', [new InputRichBlockPhoto(new InputMediaPhoto($file))]);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'details',
                'summary' => 'summary',
                'blocks' => [
                    ['type' => 'photo', 'photo' => ['type' => 'photo', 'media' => 'attach://file0']],
                ],
            ],
            $details->toRequestArray($fileCollector),
        );
        assertSame(['file0' => $file], $fileCollector->get());
    }
}
