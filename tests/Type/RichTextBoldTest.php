<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertSame;

final class RichTextBoldTest extends TestCase
{
    public function testBase(): void
    {
        $bold = new RichTextBold('hello');

        assertSame('bold', $bold->getType());
        assertSame('hello', $bold->text);
    }

    public function testFromTelegramResult(): void
    {
        $bold = (new ObjectFactory())->create([
            'type' => 'bold',
            'text' => 'hello',
        ], null, RichTextBold::class);

        assertSame('bold', $bold->getType());
        assertSame('hello', $bold->text);
    }
}
