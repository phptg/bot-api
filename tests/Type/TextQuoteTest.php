<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MessageEntity;
use Phptg\BotApi\Type\RichTextBold;
use Phptg\BotApi\Type\TextQuote;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNotNull;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class TextQuoteTest extends TestCase
{
    public function testBase(): void
    {
        $textQuote = new TextQuote('test', 23);

        assertSame('test', $textQuote->text);
        assertSame(23, $textQuote->position);
        assertNull($textQuote->entities);
        assertNull($textQuote->isManual);
        assertNull($textQuote->richTexts);
    }

    public function testFull(): void
    {
        $textQuote = new TextQuote(
            'test',
            23,
            [new MessageEntity('bold', 0, 4)],
            true,
            ['hello', new RichTextBold('world')],
        );

        assertSame('test', $textQuote->text);
        assertSame(23, $textQuote->position);

        assertNotNull($textQuote->entities);
        assertCount(1, $textQuote->entities);
        assertSame('bold', $textQuote->entities[0]->type);
        assertSame(0, $textQuote->entities[0]->offset);
        assertSame(4, $textQuote->entities[0]->length);

        assertTrue($textQuote->isManual);

        assertNotNull($textQuote->richTexts);
        assertCount(2, $textQuote->richTexts);
        assertSame('hello', $textQuote->richTexts[0]);
        assertInstanceOf(RichTextBold::class, $textQuote->richTexts[1]);
        assertSame('world', $textQuote->richTexts[1]->text);
    }

    public function testFromTelegramResult(): void
    {
        $textQuote = (new ObjectFactory())->create([
            'text' => 'test',
            'position' => 23,
        ], null, TextQuote::class);

        assertSame('test', $textQuote->text);
        assertSame(23, $textQuote->position);
        assertNull($textQuote->entities);
        assertNull($textQuote->isManual);
        assertNull($textQuote->richTexts);
    }

    public function testFromTelegramResultFull(): void
    {
        $textQuote = (new ObjectFactory())->create([
            'text' => 'test',
            'position' => 23,
            'entities' => [
                [
                    'offset' => 0,
                    'length' => 4,
                    'type' => 'bold',
                ],
            ],
            'is_manual' => true,
            'rich_texts' => [
                'hello',
                [
                    'type' => 'bold',
                    'text' => 'world',
                ],
            ],
        ], null, TextQuote::class);

        assertSame('test', $textQuote->text);
        assertSame(23, $textQuote->position);

        assertNotNull($textQuote->entities);
        assertCount(1, $textQuote->entities);
        assertSame('bold', $textQuote->entities[0]->type);
        assertSame(0, $textQuote->entities[0]->offset);
        assertSame(4, $textQuote->entities[0]->length);

        assertTrue($textQuote->isManual);

        assertNotNull($textQuote->richTexts);
        assertCount(2, $textQuote->richTexts);
        assertSame('hello', $textQuote->richTexts[0]);
        assertInstanceOf(RichTextBold::class, $textQuote->richTexts[1]);
        assertSame('world', $textQuote->richTexts[1]->text);
    }
}
