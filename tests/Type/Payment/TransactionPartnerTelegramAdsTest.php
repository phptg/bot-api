<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\TransactionPartnerTelegramAds;

use function PHPUnit\Framework\assertSame;

final class TransactionPartnerTelegramAdsTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerTelegramAds();

        assertSame('telegram_ads', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'type' => 'telegram_ads',
        ], null, TransactionPartnerTelegramAds::class);

        assertSame('telegram_ads', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerTelegramAds::class);
    }
}
