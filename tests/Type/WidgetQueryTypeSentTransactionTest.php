<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\WidgetQueryTypeSentTransaction;
use Phptg\BotApi\Type\WidgetQueryWallet;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class WidgetQueryTypeSentTransactionTest extends TestCase
{
    public function testBase(): void
    {
        $wallet = new WidgetQueryWallet('EQCDwallet', '100500');
        $queryType = new WidgetQueryTypeSentTransaction($wallet, 'abcdef123456');

        assertSame('sent_transaction', $queryType->getType());
        assertSame($wallet, $queryType->wallet);
        assertSame('abcdef123456', $queryType->msgHash);
    }

    public function testFromTelegramResult(): void
    {
        $queryType = (new ObjectFactory())->create([
            'type' => 'sent_transaction',
            'wallet' => [
                'address' => 'EQCDwallet',
                'amount' => '100500',
            ],
            'msg_hash' => 'abcdef123456',
        ], null, WidgetQueryTypeSentTransaction::class);

        assertSame('sent_transaction', $queryType->getType());
        $wallet = $queryType->wallet;
        assertInstanceOf(WidgetQueryWallet::class, $wallet);
        assertSame('EQCDwallet', $wallet->address);
        assertSame('100500', $wallet->amount);
        assertSame('abcdef123456', $queryType->msgHash);
    }
}
