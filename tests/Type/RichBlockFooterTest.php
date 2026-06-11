<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichBlockFooter;

use function PHPUnit\Framework\assertSame;

final class RichBlockFooterTest extends TestCase
{
    public function testBase(): void
    {
        $footer = new RichBlockFooter('hello');

        assertSame('footer', $footer->getType());
        assertSame('hello', $footer->text);
    }

    public function testFromTelegramResult(): void
    {
        $footer = (new ObjectFactory())->create([
            'type' => 'footer',
            'text' => 'hello',
        ], null, RichBlockFooter::class);

        assertSame('footer', $footer->getType());
        assertSame('hello', $footer->text);
    }
}
