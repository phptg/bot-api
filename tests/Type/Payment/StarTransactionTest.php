<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\StarTransaction;
use Phptg\BotApi\Type\Payment\TransactionPartnerOther;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class StarTransactionTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $object = new StarTransaction('id1', 2, $date);

        assertSame('id1', $object->id);
        assertSame(2, $object->amount);
        assertSame($date, $object->date);
        assertNull($object->source);
        assertNull($object->receiver);
        assertNull($object->nanostarAmount);
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $partner1 = new TransactionPartnerOther();
        $partner2 = new TransactionPartnerOther();
        $object = new StarTransaction(
            'id1',
            2,
            $date,
            $partner1,
            $partner2,
            900,
        );

        assertSame('id1', $object->id);
        assertSame(2, $object->amount);
        assertSame($date, $object->date);
        assertSame($partner1, $object->source);
        assertSame($partner2, $object->receiver);
        assertSame(900, $object->nanostarAmount);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'id' => 'id1',
            'amount' => 2,
            'date' => 123456789,
            'source' => [
                'type' => 'other',
            ],
            'receiver' => [
                'type' => 'other',
            ],
            'nanostar_amount' => 900,
        ], null, StarTransaction::class);

        assertSame('id1', $object->id);
        assertSame(2, $object->amount);
        assertEquals(new DateTimeImmutable('@123456789'), $object->date);
        assertInstanceOf(TransactionPartnerOther::class, $object->source);
        assertInstanceOf(TransactionPartnerOther::class, $object->receiver);
        assertSame(900, $object->nanostarAmount);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, StarTransaction::class);
    }
}
