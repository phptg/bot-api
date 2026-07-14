<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertSame;

final class InputRichBlockParagraphTest extends TestCase
{
    public function testBase(): void
    {
        $paragraph = new InputRichBlockParagraph('hello');

        assertSame('paragraph', $paragraph->getType());
        assertSame(
            ['type' => 'paragraph', 'text' => 'hello'],
            $paragraph->toRequestArray(),
        );
    }

    public function testRichTextValue(): void
    {
        $paragraph = new InputRichBlockParagraph(new RichTextBold('hello'));

        assertSame(
            ['type' => 'paragraph', 'text' => ['type' => 'bold', 'text' => 'hello']],
            $paragraph->toRequestArray(),
        );
    }
}
