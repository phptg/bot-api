<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockParagraph;

use function PHPUnit\Framework\assertSame;

final class RichBlockParagraphTest extends TestCase
{
    public function testBase(): void
    {
        $paragraph = new RichBlockParagraph('hello');

        assertSame('paragraph', $paragraph->getType());
        assertSame('hello', $paragraph->text);
    }

    public function testFromTelegramResult(): void
    {
        $paragraph = (new ObjectFactory())->create([
            'type' => 'paragraph',
            'text' => 'hello',
        ], null, RichBlockParagraph::class);

        assertSame('paragraph', $paragraph->getType());
        assertSame('hello', $paragraph->text);
    }
}
