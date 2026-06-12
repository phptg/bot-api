<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockCaption;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockCaptionTest extends TestCase
{
    public function testBase(): void
    {
        $caption = new RichBlockCaption('hello');

        assertSame('hello', $caption->text);
        assertNull($caption->credit);
    }

    public function testFull(): void
    {
        $caption = new RichBlockCaption('hello', 'world');

        assertSame('hello', $caption->text);
        assertSame('world', $caption->credit);
    }

    public function testFromTelegramResult(): void
    {
        $caption = (new ObjectFactory())->create([
            'text' => 'hello',
        ], null, RichBlockCaption::class);

        assertSame('hello', $caption->text);
        assertNull($caption->credit);
    }

    public function testFromTelegramResultFull(): void
    {
        $caption = (new ObjectFactory())->create([
            'text' => 'hello',
            'credit' => ['type' => 'bold', 'text' => 'world'],
        ], null, RichBlockCaption::class);

        assertSame('hello', $caption->text);
        assertInstanceOf(RichTextBold::class, $caption->credit);
        assertSame('world', $caption->credit->text);
    }
}
