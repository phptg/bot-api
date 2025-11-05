<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\InvalidTypeOfValueInResultException;
use Phptg\BotApi\ParseResult\NotFoundKeyInResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\ValueProcessor\MaybeInaccessibleMessageValue;
use Phptg\BotApi\Type\InaccessibleMessage;

use function PHPUnit\Framework\assertInstanceOf;

final class MaybeInaccessibleMessageValueTest extends TestCase
{
    public function testInvalidType(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $processor->process('test', null, $objectFactory);
    }

    public function testWithoutDate(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $this->expectException(NotFoundKeyInResultException::class);
        $this->expectExceptionMessage('Not found key "date" in result object.');
        $processor->process([], null, $objectFactory);
    }

    public function testInvalidTypeOfDate(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $this->expectException(InvalidTypeOfValueInResultException::class);
        $this->expectExceptionMessage(
            'Invalid type of value for key "date". Expected type is "integer", but got "string".',
        );
        $processor->process(['date' => '19.11.2013'], null, $objectFactory);
    }

    public function testInaccessibleMessage(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new MaybeInaccessibleMessageValue();

        $result = $processor->process(
            [
                'message_id' => 7,
                'date' => 0,
                'chat' => [
                    'id' => 123456789,
                    'type' => 'private',
                ],
            ],
            null,
            $objectFactory,
        );

        assertInstanceOf(InaccessibleMessage::class, $result);
    }
}
