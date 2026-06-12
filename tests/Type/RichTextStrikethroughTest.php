<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextStrikethrough;

use function PHPUnit\Framework\assertSame;

final class RichTextStrikethroughTest extends TestCase
{
    public function testBase(): void
    {
        $strikethrough = new RichTextStrikethrough('hello');

        assertSame('strikethrough', $strikethrough->getType());
        assertSame('hello', $strikethrough->text);
    }

    public function testFromTelegramResult(): void
    {
        $strikethrough = (new ObjectFactory())->create([
            'type' => 'strikethrough',
            'text' => 'hello',
        ], null, RichTextStrikethrough::class);

        assertSame('strikethrough', $strikethrough->getType());
        assertSame('hello', $strikethrough->text);
    }
}
