<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use Phptg\BotApi\ParseResult\ValueProcessor\StringValue;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayMap;

final class ArrayMapTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new ArrayMap(StringValue::class);

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $processor->process('test', null, $objectFactory);
    }
}
