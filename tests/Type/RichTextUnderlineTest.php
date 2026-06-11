<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextUnderline;

use function PHPUnit\Framework\assertSame;

final class RichTextUnderlineTest extends TestCase
{
    public function testBase(): void
    {
        $underline = new RichTextUnderline('hello');

        assertSame('underline', $underline->getType());
        assertSame('hello', $underline->text);
    }

    public function testFromTelegramResult(): void
    {
        $underline = (new ObjectFactory())->create([
            'type' => 'underline',
            'text' => 'hello',
        ], null, RichTextUnderline::class);

        assertSame('underline', $underline->getType());
        assertSame('hello', $underline->text);
    }
}
