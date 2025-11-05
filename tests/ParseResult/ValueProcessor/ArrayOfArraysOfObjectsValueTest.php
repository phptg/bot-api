<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfArraysOfObjectsValue;
use Phptg\BotApi\Type\BotName;

final class ArrayOfArraysOfObjectsValueTest extends TestCase
{
    public function testNotArray(): void
    {
        $processor = new ArrayOfArraysOfObjectsValue(BotName::class);
        $objectFactory = new ObjectFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array[]", but got "string".');
        $processor->process('test', null, $objectFactory);
    }

    public function testNotArrayItems(): void
    {
        $processor = new ArrayOfArraysOfObjectsValue(BotName::class);
        $objectFactory = new ObjectFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array[]", but got "string".');
        $processor->process(['test'], null, $objectFactory);
    }
}
