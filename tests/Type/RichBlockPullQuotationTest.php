<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockPullQuotation;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockPullQuotationTest extends TestCase
{
    public function testBase(): void
    {
        $pullquote = new RichBlockPullQuotation('hello');

        assertSame('pullquote', $pullquote->getType());
        assertSame('hello', $pullquote->text);
        assertNull($pullquote->credit);
    }

    public function testFull(): void
    {
        $pullquote = new RichBlockPullQuotation('hello', 'credit');

        assertSame('pullquote', $pullquote->getType());
        assertSame('hello', $pullquote->text);
        assertSame('credit', $pullquote->credit);
    }

    public function testFromTelegramResult(): void
    {
        $pullquote = (new ObjectFactory())->create([
            'type' => 'pullquote',
            'text' => 'hello',
        ], null, RichBlockPullQuotation::class);

        assertSame('pullquote', $pullquote->getType());
        assertSame('hello', $pullquote->text);
        assertNull($pullquote->credit);
    }

    public function testFromTelegramResultFull(): void
    {
        $pullquote = (new ObjectFactory())->create([
            'type' => 'pullquote',
            'text' => ['type' => 'bold', 'text' => 'hello'],
            'credit' => ['type' => 'bold', 'text' => 'author'],
        ], null, RichBlockPullQuotation::class);

        assertSame('pullquote', $pullquote->getType());
        assertInstanceOf(RichTextBold::class, $pullquote->text);
        assertSame('hello', $pullquote->text->text);
        assertInstanceOf(RichTextBold::class, $pullquote->credit);
        assertSame('author', $pullquote->credit->text);
    }
}
