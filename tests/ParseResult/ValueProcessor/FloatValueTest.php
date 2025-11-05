<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\ValueProcessor\FloatValue;

final class FloatValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new FloatValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "float", but got "string".');
        $processor->process('test', null, $objectFactory);
    }
}
