<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\RefundedPayment;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RefundedPaymentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new RefundedPayment('XTR', 12, 'ip', 'tpid');

        assertSame('XTR', $type->currency);
        assertSame(12, $type->totalAmount);
        assertSame('ip', $type->invoicePayload);
        assertSame('tpid', $type->telegramPaymentChargeId);
        assertNull($type->providerPaymentChargeId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'currency' => 'XTR',
                'total_amount' => 12,
                'invoice_payload' => 'ip',
                'telegram_payment_charge_id' => 'tpid',
                'provider_payment_charge_id' => 'ppcid',
            ],
            null,
            RefundedPayment::class,
        );

        assertSame('XTR', $type->currency);
        assertSame(12, $type->totalAmount);
        assertSame('ip', $type->invoicePayload);
        assertSame('tpid', $type->telegramPaymentChargeId);
        assertSame('ppcid', $type->providerPaymentChargeId);
    }
}
