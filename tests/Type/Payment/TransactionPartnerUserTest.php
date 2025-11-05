<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\PaidMediaPhoto;
use Phptg\BotApi\Type\PaidMediaPreview;
use Phptg\BotApi\Type\Payment\AffiliateInfo;
use Phptg\BotApi\Type\Payment\TransactionPartnerUser;
use Phptg\BotApi\Type\PhotoSize;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TransactionPartnerUserTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'Mike');
        $object = new TransactionPartnerUser('invoice_payment', $user);

        assertSame('user', $object->getType());
        assertSame('invoice_payment', $object->transactionType);
        assertSame($user, $object->user);
        assertNull($object->invoicePayload);
        assertNull($object->paidMedia);
        assertNull($object->paidMediaPayload);
        assertNull($object->subscriptionPeriod);
        assertNull($object->gift);
        assertNull($object->affiliate);
        assertNull($object->premiumSubscriptionDuration);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Mike');
        $paidMedia = [new PaidMediaPreview(), new PaidMediaPreview()];
        $affiliate = new AffiliateInfo(100, 200);
        $object = new TransactionPartnerUser(
            'invoice_payment',
            $user,
            'test',
            $paidMedia,
            'paid-payload',
            19,
            'The Gift',
            $affiliate,
            56,
        );

        assertSame('user', $object->getType());
        assertSame('invoice_payment', $object->transactionType);
        assertSame($user, $object->user);
        assertSame('test', $object->invoicePayload);
        assertSame($paidMedia, $object->paidMedia);
        assertSame('paid-payload', $object->paidMediaPayload);
        assertSame(19, $object->subscriptionPeriod);
        assertSame('The Gift', $object->gift);
        assertSame($affiliate, $object->affiliate);
        assertSame(56, $object->premiumSubscriptionDuration);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'type' => 'user',
                'transaction_type' => 'gift_purchase',
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'affiliate' => [
                    'commission_per_mille' => 100,
                    'amount' => 200,
                ],
                'invoice_payload' => 'test',
                'paid_media' => [
                    [
                        'type' => 'photo',
                        'photo' => [
                            [
                                'file_id' => 'fid1',
                                'file_unique_id' => 'fuid1',
                                'width' => 100,
                                'height' => 200,
                            ],
                        ],
                    ],
                    [
                        'type' => 'preview',

                    ],
                ],
                'paid_media_payload' => 'test-payload',
                'premium_subscription_duration' => 192,
            ],
            null,
            TransactionPartnerUser::class,
        );

        assertSame('user', $object->getType());
        assertSame('gift_purchase', $object->transactionType);
        assertSame(123, $object->user->id);
        assertSame('test', $object->invoicePayload);
        assertEquals(
            [
                new PaidMediaPhoto([new PhotoSize('fid1', 'fuid1', 100, 200)]),
                new PaidMediaPreview(),
            ],
            $object->paidMedia,
        );
        assertSame('test-payload', $object->paidMediaPayload);
        assertSame(100, $object->affiliate->commissionPerMille);
        assertSame(192, $object->premiumSubscriptionDuration);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerUser::class);
    }
}
