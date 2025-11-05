<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\NotFoundKeyInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\ValueProcessor\MessageOriginValue;

final class InterfaceValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $processor->process('test', null, $objectFactory);
    }

    public function testWithoutTypeKey(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "type" in result object.');
        $processor->process([], null, $objectFactory);
    }

    public function testInvalidTypeOfTypeKey(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MessageOriginValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "type". Expected type is "string", but got "int".',
        );
        $processor->process(['type' => 23], null, $objectFactory);
    }
}
