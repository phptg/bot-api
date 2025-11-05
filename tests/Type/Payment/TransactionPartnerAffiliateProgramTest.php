<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Type\Payment\TransactionPartnerAffiliateProgram;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TransactionPartnerAffiliateProgramTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerAffiliateProgram(200);

        assertSame('affiliate_program', $object->getType());
        assertSame(200, $object->commissionPerMille);
        assertNull($object->sponsorUser);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Mike');
        $object = new TransactionPartnerAffiliateProgram(
            200,
            $user,
        );

        assertSame('affiliate_program', $object->getType());
        assertSame(200, $object->commissionPerMille);
        assertSame($user, $object->sponsorUser);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create(
            [
                'type' => 'affiliate_program',
                'sponsor_user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'commission_per_mille' => 203,
            ],
            null,
            TransactionPartnerAffiliateProgram::class,
        );

        assertSame('affiliate_program', $object->getType());
        assertSame(203, $object->commissionPerMille);
        assertSame(123, $object->sponsorUser->id);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerAffiliateProgram::class);
    }
}
