<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\WidgetQueryTypeSignData;
use Phptg\BotApi\Type\WidgetQueryWallet;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class WidgetQueryTypeSignDataTest extends TestCase
{
    public function testBase(): void
    {
        $wallet = new WidgetQueryWallet('EQCDwallet', '100500');
        $queryType = new WidgetQueryTypeSignData($wallet, '{"serial_id":123}');

        assertSame('sign_data', $queryType->getType());
        assertSame($wallet, $queryType->wallet);
        assertSame('{"serial_id":123}', $queryType->signData);
    }

    public function testFromTelegramResult(): void
    {
        $queryType = (new ObjectFactory())->create([
            'type' => 'sign_data',
            'wallet' => [
                'address' => 'EQCDwallet',
                'amount' => '100500',
                'public_key' => 'a1b2c3d4',
                'state_init' => 'te6cckEBAQEAJg',
            ],
            'sign_data' => '{"serial_id":123}',
        ], null, WidgetQueryTypeSignData::class);

        assertSame('sign_data', $queryType->getType());
        $wallet = $queryType->wallet;
        assertInstanceOf(WidgetQueryWallet::class, $wallet);
        assertSame('EQCDwallet', $wallet->address);
        assertSame('a1b2c3d4', $wallet->publicKey);
        assertSame('te6cckEBAQEAJg', $wallet->stateInit);
        assertSame('{"serial_id":123}', $queryType->signData);
    }
}
