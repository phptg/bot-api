<?php

declare(strict_types=1);

namespace Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\PaidMediaPurchased;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class PaidMediaPurchasedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Vjik');
        $object = new PaidMediaPurchased($user, 'payload');

        assertSame($user, $object->from);
        assertSame('payload', $object->paidMediaPayload);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'from' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Vjik',
                ],
                'paid_media_payload' => 'test',
            ],
            null,
            PaidMediaPurchased::class,
        );

        assertInstanceOf(User::class, $object->from);
        assertSame(1, $object->from->id);

        assertSame('test', $object->paidMediaPayload);
    }
}
