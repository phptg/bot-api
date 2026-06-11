<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextSuperscript;

use function PHPUnit\Framework\assertSame;

final class RichTextSuperscriptTest extends TestCase
{
    public function testBase(): void
    {
        $superscript = new RichTextSuperscript('hello');

        assertSame('superscript', $superscript->getType());
        assertSame('hello', $superscript->text);
    }

    public function testFromTelegramResult(): void
    {
        $superscript = (new ObjectFactory())->create([
            'type' => 'superscript',
            'text' => 'hello',
        ], null, RichTextSuperscript::class);

        assertSame('superscript', $superscript->getType());
        assertSame('hello', $superscript->text);
    }
}
