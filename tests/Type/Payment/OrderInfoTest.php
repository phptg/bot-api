<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\OrderInfo;
use Phptg\BotApi\Type\Payment\ShippingAddress;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class OrderInfoTest extends TestCase
{
    public function testOrderInfo(): void
    {
        $orderInfo = new OrderInfo();

        assertNull($orderInfo->name);
        assertNull($orderInfo->phoneNumber);
        assertNull($orderInfo->email);
        assertNull($orderInfo->shippingAddress);
    }

    public function testFromTelegramResult(): void
    {
        $orderInfo = (new ObjectFactory())->create([
            'name' => 'name',
            'phone_number' => 'phone_number',
            'email' => 'email',
            'shipping_address' => [
                'country_code' => 'country_code',
                'state' => 'state',
                'city' => 'city',
                'street_line1' => 'street_line1',
                'street_line2' => 'street_line2',
                'post_code' => 'post_code',
            ],
        ], null, OrderInfo::class);

        assertSame('name', $orderInfo->name);
        assertSame('phone_number', $orderInfo->phoneNumber);
        assertSame('email', $orderInfo->email);

        assertInstanceOf(ShippingAddress::class, $orderInfo->shippingAddress);
        assertSame('country_code', $orderInfo->shippingAddress->countryCode);
        assertSame('state', $orderInfo->shippingAddress->state);
        assertSame('city', $orderInfo->shippingAddress->city);
        assertSame('street_line1', $orderInfo->shippingAddress->streetLine1);
        assertSame('street_line2', $orderInfo->shippingAddress->streetLine2);
        assertSame('post_code', $orderInfo->shippingAddress->postCode);
    }
}
