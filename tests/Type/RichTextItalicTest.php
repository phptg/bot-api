<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextItalic;

use function PHPUnit\Framework\assertSame;

final class RichTextItalicTest extends TestCase
{
    public function testBase(): void
    {
        $italic = new RichTextItalic('hello');

        assertSame('italic', $italic->getType());
        assertSame('hello', $italic->text);
    }

    public function testFromTelegramResult(): void
    {
        $italic = (new ObjectFactory())->create([
            'type' => 'italic',
            'text' => 'hello',
        ], null, RichTextItalic::class);

        assertSame('italic', $italic->getType());
        assertSame('hello', $italic->text);
    }
}
