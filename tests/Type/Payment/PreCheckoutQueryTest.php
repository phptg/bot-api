<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\OrderInfo;
use Phptg\BotApi\Type\Payment\PreCheckoutQuery;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class PreCheckoutQueryTest extends TestCase
{
    public function testPreCheckoutQuery(): void
    {
        $user = new User(1, false, 'Vjik');
        $preCheckoutQuery = new PreCheckoutQuery(
            'id',
            $user,
            'RUB',
            123,
            'pl23',
        );

        assertSame('id', $preCheckoutQuery->id);
        assertSame($user, $preCheckoutQuery->from);
        assertSame('RUB', $preCheckoutQuery->currency);
        assertSame(123, $preCheckoutQuery->totalAmount);
        assertSame('pl23', $preCheckoutQuery->invoicePayload);
        assertNull($preCheckoutQuery->shippingOptionId);
        assertNull($preCheckoutQuery->orderInfo);
    }

    public function testFromTelegramResult(): void
    {
        $preCheckoutQuery = (new ObjectFactory())->create([
            'id' => 'id',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Vjik',
            ],
            'currency' => 'RUB',
            'total_amount' => 123,
            'invoice_payload' => 'pl23',
            'shipping_option_id' => 'o12',
            'order_info' => [
                'name' => 'OrderName',
            ],
        ], null, PreCheckoutQuery::class);

        assertSame('id', $preCheckoutQuery->id);

        assertInstanceOf(User::class, $preCheckoutQuery->from);
        assertSame(1, $preCheckoutQuery->from->id);

        assertSame('RUB', $preCheckoutQuery->currency);
        assertSame(123, $preCheckoutQuery->totalAmount);
        assertSame('pl23', $preCheckoutQuery->invoicePayload);
        assertSame('o12', $preCheckoutQuery->shippingOptionId);

        assertInstanceOf(OrderInfo::class, $preCheckoutQuery->orderInfo);
        assertSame('OrderName', $preCheckoutQuery->orderInfo->name);
    }
}
