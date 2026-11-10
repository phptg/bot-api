<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\NotFoundKeyInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ValueProcessor\RichTextValue;
use Phptg\BotApi\Type\RichTextBold;
use Phptg\BotApi\Type\RichTextTonAddress;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertSame;

final class RichTextValueTest extends TestCase
{
    public function testString(): void
    {
        $result = (new RichTextValue())->process('hello', null, new ObjectFactory());

        assertIsString($result);
    }

    public function testArray(): void
    {
        $result = (new RichTextValue())->process(
            [
                'hello',
                ['type' => 'bold', 'text' => 'world'],
            ],
            null,
            new ObjectFactory(),
        );

        assertEquals(['hello', new RichTextBold('world')], $result);
    }

    public function testRichText(): void
    {
        $result = (new RichTextValue())->process(
            ['type' => 'bold', 'text' => 'hello'],
            null,
            new ObjectFactory(),
        );

        assertEquals(new RichTextBold('hello'), $result);
    }

    public function testTonAddress(): void
    {
        $result = (new RichTextValue())->process(
            ['type' => 'ton_address', 'text' => 'hello', 'address' => 'EQABnft'],
            null,
            new ObjectFactory(),
        );

        assertInstanceOf(RichTextTonAddress::class, $result);
        assertSame('hello', $result->text);
        assertSame('EQABnft', $result->address);
    }

    public function testInvalidType(): void
    {
        $processor = new RichTextValue();
        $objectFactory = new ObjectFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "string or array", but got "int".');
        $processor->process(42, null, $objectFactory);
    }

    public function testMissingTypeKey(): void
    {
        $processor = new RichTextValue();
        $objectFactory = new ObjectFactory();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "type" in result object.');
        $processor->process(['foo' => 'bar'], null, $objectFactory);
    }

    public function testInvalidTypeKey(): void
    {
        $processor = new RichTextValue();
        $objectFactory = new ObjectFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "type". Expected type is "string", but got "int".',
        );
        $processor->process(['type' => 42], null, $objectFactory);
    }

    public function testUnknownType(): void
    {
        $processor = new RichTextValue();
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown rich text type.');
        $processor->process(['type' => 'unknown'], null, $objectFactory);
    }
}
