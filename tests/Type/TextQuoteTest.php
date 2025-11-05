<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\TextQuote;

use function PHPUnit\Framework\assertCount;
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
    }

    public function testFromTelegramResult(): void
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
        ], null, TextQuote::class);

        assertSame('test', $textQuote->text);
        assertSame(23, $textQuote->position);

        assertCount(1, $textQuote->entities);
        assertSame('bold', $textQuote->entities[0]->type);
        assertSame(0, $textQuote->entities[0]->offset);
        assertSame(4, $textQuote->entities[0]->length);

        assertTrue($textQuote->isManual);
    }
}
