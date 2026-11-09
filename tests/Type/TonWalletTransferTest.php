<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\TonWalletTransfer;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TonWalletTransferTest extends TestCase
{
    public function testBase(): void
    {
        $transfer = new TonWalletTransfer('EQABtransaction', 'EQCDwallet', '100500');

        assertSame('EQABtransaction', $transfer->transactionId);
        assertSame('EQCDwallet', $transfer->peerAddress);
        assertSame('100500', $transfer->amount);
        assertNull($transfer->comment);
    }

    public function testFull(): void
    {
        $transfer = new TonWalletTransfer('EQABtransaction', 'EQCDwallet', '100500', 'Coffee payment');

        assertSame('EQABtransaction', $transfer->transactionId);
        assertSame('EQCDwallet', $transfer->peerAddress);
        assertSame('100500', $transfer->amount);
        assertSame('Coffee payment', $transfer->comment);
    }

    public function testFromTelegramResult(): void
    {
        $transfer = (new ObjectFactory())->create([
            'transaction_id' => 'EQABtransaction',
            'peer_address' => 'EQCDwallet',
            'amount' => '100500',
        ], null, TonWalletTransfer::class);

        assertSame('EQABtransaction', $transfer->transactionId);
        assertSame('EQCDwallet', $transfer->peerAddress);
        assertSame('100500', $transfer->amount);
        assertNull($transfer->comment);
    }

    public function testFromTelegramResultFull(): void
    {
        $transfer = (new ObjectFactory())->create([
            'transaction_id' => 'EQABtransaction',
            'peer_address' => 'EQCDwallet',
            'amount' => '100500',
            'comment' => 'Coffee payment',
        ], null, TonWalletTransfer::class);

        assertSame('EQABtransaction', $transfer->transactionId);
        assertSame('EQCDwallet', $transfer->peerAddress);
        assertSame('100500', $transfer->amount);
        assertSame('Coffee payment', $transfer->comment);
    }
}
