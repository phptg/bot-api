<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\ShippingAddress;
use Phptg\BotApi\Type\Payment\ShippingQuery;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ShippingQueryTest extends TestCase
{
    public function testShippingQuery(): void
    {
        $user = new User(1, false, 'Vjik');
        $shippingAddress = new ShippingAddress(
            'country_code',
            'state',
            'city',
            'street_line1',
            'street_line2',
            'post_code',
        );
        $shippingQuery = new ShippingQuery(
            'id',
            $user,
            'p12',
            $shippingAddress,
        );

        assertSame('id', $shippingQuery->id);
        assertSame($user, $shippingQuery->from);
        assertSame('p12', $shippingQuery->invoicePayload);
        assertSame($shippingAddress, $shippingQuery->shippingAddress);
    }

    public function testFromTelegramResult(): void
    {
        $shippingQuery = (new ObjectFactory())->create([
            'id' => 'id',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Vjik',
            ],
            'invoice_payload' => 'pl23',
            'shipping_address' => [
                'country_code' => 'country_code',
                'state' => 'state',
                'city' => 'city',
                'street_line1' => 'street_line1',
                'street_line2' => 'street_line2',
                'post_code' => 'post_code',
            ],
        ], null, ShippingQuery::class);

        assertSame('id', $shippingQuery->id);

        assertInstanceOf(User::class, $shippingQuery->from);
        assertSame(1, $shippingQuery->from->id);

        assertSame('pl23', $shippingQuery->invoicePayload);

        assertSame('country_code', $shippingQuery->shippingAddress->countryCode);
        assertSame('state', $shippingQuery->shippingAddress->state);
        assertSame('city', $shippingQuery->shippingAddress->city);
        assertSame('street_line1', $shippingQuery->shippingAddress->streetLine1);
        assertSame('street_line2', $shippingQuery->shippingAddress->streetLine2);
        assertSame('post_code', $shippingQuery->shippingAddress->postCode);
    }
}
