<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextSubscript;

use function PHPUnit\Framework\assertSame;

final class RichTextSubscriptTest extends TestCase
{
    public function testBase(): void
    {
        $subscript = new RichTextSubscript('hello');

        assertSame('subscript', $subscript->getType());
        assertSame('hello', $subscript->text);
    }

    public function testFromTelegramResult(): void
    {
        $subscript = (new ObjectFactory())->create([
            'type' => 'subscript',
            'text' => 'hello',
        ], null, RichTextSubscript::class);

        assertSame('subscript', $subscript->getType());
        assertSame('hello', $subscript->text);
    }
}
