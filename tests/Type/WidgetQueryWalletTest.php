<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\WidgetQueryWallet;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class WidgetQueryWalletTest extends TestCase
{
    public function testBase(): void
    {
        $wallet = new WidgetQueryWallet('EQCDwallet', '100500');

        assertSame('EQCDwallet', $wallet->address);
        assertSame('100500', $wallet->amount);
        assertNull($wallet->publicKey);
        assertNull($wallet->stateInit);
    }

    public function testFull(): void
    {
        $wallet = new WidgetQueryWallet('EQCDwallet', '100500', 'a1b2c3d4', 'te6cckEBAQEAJg');

        assertSame('EQCDwallet', $wallet->address);
        assertSame('100500', $wallet->amount);
        assertSame('a1b2c3d4', $wallet->publicKey);
        assertSame('te6cckEBAQEAJg', $wallet->stateInit);
    }

    public function testFromTelegramResult(): void
    {
        $wallet = (new ObjectFactory())->create([
            'address' => 'EQCDwallet',
            'amount' => '100500',
        ], null, WidgetQueryWallet::class);

        assertSame('EQCDwallet', $wallet->address);
        assertSame('100500', $wallet->amount);
        assertNull($wallet->publicKey);
        assertNull($wallet->stateInit);
    }

    public function testFromTelegramResultFull(): void
    {
        $wallet = (new ObjectFactory())->create([
            'address' => 'EQCDwallet',
            'amount' => '100500',
            'public_key' => 'a1b2c3d4',
            'state_init' => 'te6cckEBAQEAJg',
        ], null, WidgetQueryWallet::class);

        assertSame('EQCDwallet', $wallet->address);
        assertSame('100500', $wallet->amount);
        assertSame('a1b2c3d4', $wallet->publicKey);
        assertSame('te6cckEBAQEAJg', $wallet->stateInit);
    }
}
