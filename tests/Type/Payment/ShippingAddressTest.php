<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\ShippingAddress;

use function PHPUnit\Framework\assertSame;

final class ShippingAddressTest extends TestCase
{
    public function testBase(): void
    {
        $shippingAddress = new ShippingAddress('ru', 'the-state', 'the-city', 'the-street1', 'the-street2', '111');

        assertSame('ru', $shippingAddress->countryCode);
        assertSame('the-state', $shippingAddress->state);
        assertSame('the-city', $shippingAddress->city);
        assertSame('the-street1', $shippingAddress->streetLine1);
        assertSame('the-street2', $shippingAddress->streetLine2);
        assertSame('111', $shippingAddress->postCode);
    }

    public function testFromTelegramResult(): void
    {
        $shippingAddress = (new ObjectFactory())->create([
            'country_code' => 'ru',
            'state' => 'state',
            'city' => 'city',
            'street_line1' => 'street1',
            'street_line2' => 'street2',
            'post_code' => '213',
        ], null, ShippingAddress::class);

        assertSame('ru', $shippingAddress->countryCode);
        assertSame('state', $shippingAddress->state);
        assertSame('city', $shippingAddress->city);
        assertSame('street1', $shippingAddress->streetLine1);
        assertSame('street2', $shippingAddress->streetLine2);
        assertSame('213', $shippingAddress->postCode);
    }
}
