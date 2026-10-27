<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\InputRichBlockParagraph;
use Phptg\BotApi\Type\RichTextBold;
use Phptg\BotApi\Type\RichTextItalic;
use stdClass;

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

    public static function dataText(): iterable
    {
        yield 'rich text' => [
            ['type' => 'bold', 'text' => 'hello'],
            new RichTextBold('hello'),
        ];
        yield 'array' => [
            ['hello', ['type' => 'bold', 'text' => 'world']],
            ['hello', new RichTextBold('world')],
        ];
        yield 'nested array' => [
            [
                'a',
                [
                    ['type' => 'bold', 'text' => 'b'],
                    ['c', [['type' => 'italic', 'text' => ['d', 'e']]]],
                ],
            ],
            [
                'a',
                [
                    new RichTextBold('b'),
                    ['c', [new RichTextItalic(['d', 'e'])]],
                ],
            ],
        ];
        yield 'array with keys' => [
            ['a', ['b', 'c']],
            [3 => 'a', 'x' => [1 => 'b', 'y' => 'c']],
        ];
    }

    #[DataProvider('dataText')]
    public function testText(array|string $expected, array|RichTextBold $text): void
    {
        $paragraph = new InputRichBlockParagraph($text);

        assertSame(
            ['type' => 'paragraph', 'text' => $expected],
            $paragraph->toRequestArray(),
        );
    }

    public static function dataInvalidText(): iterable
    {
        yield 'object' => [[new stdClass()], 'stdClass'];
        yield 'nested object' => [['hello', [new stdClass()]], 'stdClass'];
        yield 'int' => [[[123]], 'int'];
        yield 'bool' => [[[true]], 'bool'];
        yield 'null' => [['hello', null], 'null'];
        yield 'deeply nested float' => [[[[[1.5]]]], 'float'];
    }

    #[DataProvider('dataInvalidText')]
    public function testInvalidText(array $text, string $givenType): void
    {
        $paragraph = new InputRichBlockParagraph($text);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Rich text must be a string, a RichText object or an array of them. ' . $givenType . ' given.',
        );
        $paragraph->toRequestArray();
    }
}
