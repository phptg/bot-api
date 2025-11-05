<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult;

use LogicException;
use PHPUnit\Framework\TestCase;
use Throwable;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\NotFoundKeyInResultException;
use Phptg\BotApi\ParseResult\ResultFactory;
use Phptg\BotApi\ParseResult\ValueProcessor\ObjectValue;
use Phptg\BotApi\Tests\Support\Car;
use Phptg\BotApi\Tests\Support\Color;
use Phptg\BotApi\Type\BotName;
use Phptg\BotApi\Type\ChatLocation;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ResultFactoryTest extends TestCase
{
    public function testUnsupportedPhpType(): void
    {
        $factory = new ResultFactory();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unsupported PHP type.');
        $factory->create(['engine' => 'test'], new ObjectValue(Car::class));
    }

    public function testNotFoundKey(): void
    {
        $factory = new ResultFactory();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "name" in result object.');
        $factory->create([], new ObjectValue(BotName::class));
    }

    public function testInvalidTypeOfValueWithKey(): void
    {
        $factory = new ResultFactory();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "name". Expected type is "string", but got "int".',
        );
        $factory->create(['name' => 23], new ObjectValue(BotName::class));
    }

    public function testNotExistsClass(): void
    {
        $factory = new ResultFactory();

        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Unsupported PHP type: Phptg\BotApi\Tests\Support\NotExists');
        $factory->create([], new ObjectValue(Color::class));
    }

    public function testNestedIncorrectArray(): void
    {
        $factory = new ResultFactory();

        $exception = null;
        $data = ['location' => ['latitude' => 'test'], 'address' => 'Earth'];
        try {
            $factory->create($data, new ObjectValue(ChatLocation::class));
        } catch (Throwable $exception) {
        }
        assertInstanceOf(InvalidTypeOfValueInResultException::class, $exception);
        assertSame(0, $exception->getCode());
        assertSame(
            'Invalid type of value for key "latitude". Expected type is "float", but got "string".',
            $exception->getMessage(),
        );
    }
}
