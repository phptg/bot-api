<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\BotSubscriptionUpdated;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class BotSubscriptionUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Vjik');
        $object = new BotSubscriptionUpdated($user, 'payload', 'canceled');

        assertSame($user, $object->user);
        assertSame('payload', $object->invoicePayload);
        assertSame('canceled', $object->state);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Vjik',
                ],
                'invoice_payload' => 'test',
                'state' => 'active',
            ],
            null,
            BotSubscriptionUpdated::class,
        );

        assertInstanceOf(User::class, $object->user);
        assertSame(1, $object->user->id);
        assertSame('test', $object->invoicePayload);
        assertSame('active', $object->state);
    }
}
