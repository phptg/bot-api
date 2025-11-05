<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Type\Payment\TransactionPartnerTelegramApi;

use function PHPUnit\Framework\assertSame;

final class TransactionPartnerTelegramApiTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerTelegramApi(3);

        assertSame('telegram_api', $object->getType());
        assertSame(3, $object->requestCount);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'type' => 'telegram_api',
                'request_count' => 7,
            ],
            null,
            TransactionPartnerTelegramApi::class,
        );

        assertSame('telegram_api', $object->getType());
        assertSame(7, $object->requestCount);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerTelegramApi::class);
    }
}
