<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\OrderInfo;
use Phptg\BotApi\Type\Payment\SuccessfulPayment;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SuccessfulPaymentTest extends TestCase
{
    public function testSuccessfulPayment(): void
    {
        $type = new SuccessfulPayment(
            'RUB',
            200,
            'pl12',
            'tpc_id',
            'ppc_id',
        );

        assertSame('RUB', $type->currency);
        assertSame(200, $type->totalAmount);
        assertSame('pl12', $type->invoicePayload);
        assertSame('tpc_id', $type->telegramPaymentChargeId);
        assertSame('ppc_id', $type->providerPaymentChargeId);
        assertNull($type->shippingOptionId);
        assertNull($type->orderInfo);
        assertNull($type->subscriptionExpirationDate);
        assertNull($type->isRecurring);
        assertNull($type->isFirstRecurring);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'currency' => 'RUB',
            'total_amount' => 900,
            'invoice_payload' => 'pl12',
            'subscription_expiration_date' => 1731915609,
            'is_recurring' => true,
            'is_first_recurring' => true,
            'telegram_payment_charge_id' => 'tpcId',
            'provider_payment_charge_id' => 'ppcId',
            'shipping_option_id' => 'soId',
            'order_info' => [
                'name' => 'OrderName',
            ],
        ], null, SuccessfulPayment::class);

        assertSame('RUB', $type->currency);
        assertSame(900, $type->totalAmount);
        assertSame('pl12', $type->invoicePayload);
        assertSame('tpcId', $type->telegramPaymentChargeId);
        assertSame('ppcId', $type->providerPaymentChargeId);
        assertSame('soId', $type->shippingOptionId);

        assertInstanceOf(OrderInfo::class, $type->orderInfo);
        assertSame('OrderName', $type->orderInfo->name);

        assertSame(1731915609, $type->subscriptionExpirationDate?->getTimestamp());
        assertTrue($type->isRecurring);
        assertTrue($type->isFirstRecurring);
    }
}
