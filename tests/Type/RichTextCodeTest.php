<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextCode;

use function PHPUnit\Framework\assertSame;

final class RichTextCodeTest extends TestCase
{
    public function testBase(): void
    {
        $code = new RichTextCode('hello');

        assertSame('code', $code->getType());
        assertSame('hello', $code->text);
    }

    public function testFromTelegramResult(): void
    {
        $code = (new ObjectFactory())->create([
            'type' => 'code',
            'text' => 'hello',
        ], null, RichTextCode::class);

        assertSame('code', $code->getType());
        assertSame('hello', $code->text);
    }
}
