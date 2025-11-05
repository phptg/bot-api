<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\RevenueWithdrawalStateSucceeded;

use function PHPUnit\Framework\assertSame;

final class RevenueWithdrawalStateSucceededTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $object = new RevenueWithdrawalStateSucceeded(
            $date,
            'https://example.com/test',
        );

        assertSame('succeeded', $object->getType());
        assertSame($date, $object->date);
        assertSame('https://example.com/test', $object->url);
    }

    public function testFromTelegramResult(): void
    {
        $date = new DateTimeImmutable();
        $object = (new ObjectFactory())->create([
            'type' => 'succeeded',
            'date' => $date->getTimestamp(),
            'url' => 'https://example.com/test',
        ], null, RevenueWithdrawalStateSucceeded::class);

        assertSame('succeeded', $object->getType());
        assertSame($date->getTimestamp(), $object->date->getTimestamp());
        assertSame('https://example.com/test', $object->url);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, RevenueWithdrawalStateSucceeded::class);
    }
}
