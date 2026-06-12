<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockPreformatted;
use Phptg\BotApi\Type\RichTextBold;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichBlockPreformattedTest extends TestCase
{
    public function testBase(): void
    {
        $pre = new RichBlockPreformatted('hello');

        assertSame('pre', $pre->getType());
        assertSame('hello', $pre->text);
        assertNull($pre->language);
    }

    public function testFull(): void
    {
        $pre = new RichBlockPreformatted('hello', 'php');

        assertSame('pre', $pre->getType());
        assertSame('hello', $pre->text);
        assertSame('php', $pre->language);
    }

    public function testFromTelegramResult(): void
    {
        $pre = (new ObjectFactory())->create([
            'type' => 'pre',
            'text' => 'hello',
        ], null, RichBlockPreformatted::class);

        assertSame('pre', $pre->getType());
        assertSame('hello', $pre->text);
        assertNull($pre->language);
    }

    public function testFromTelegramResultFull(): void
    {
        $pre = (new ObjectFactory())->create([
            'type' => 'pre',
            'text' => ['type' => 'bold', 'text' => 'hello'],
            'language' => 'python',
        ], null, RichBlockPreformatted::class);

        assertSame('pre', $pre->getType());
        assertInstanceOf(RichTextBold::class, $pre->text);
        assertSame('hello', $pre->text->text);
        assertSame('python', $pre->language);
    }
}
