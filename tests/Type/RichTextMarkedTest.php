<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextMarked;

use function PHPUnit\Framework\assertSame;

final class RichTextMarkedTest extends TestCase
{
    public function testBase(): void
    {
        $marked = new RichTextMarked('hello');

        assertSame('marked', $marked->getType());
        assertSame('hello', $marked->text);
    }

    public function testFromTelegramResult(): void
    {
        $marked = (new ObjectFactory())->create([
            'type' => 'marked',
            'text' => 'hello',
        ], null, RichTextMarked::class);

        assertSame('marked', $marked->getType());
        assertSame('hello', $marked->text);
    }
}
