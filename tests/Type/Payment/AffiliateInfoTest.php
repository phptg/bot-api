<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Payment\AffiliateInfo;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class AffiliateInfoTest extends TestCase
{
    public function testBase(): void
    {
        $type = new AffiliateInfo(100, 200);

        assertSame(100, $type->commissionPerMille);
        assertSame(200, $type->amount);
        assertNull($type->nanostarAmount);
        assertNull($type->affiliateUser);
        assertNull($type->affiliateChat);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'affiliate_user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'affiliate_chat' => [
                'id' => 456,
                'type' => 'private',
            ],
            'commission_per_mille' => 100,
            'amount' => 200,
            'nanostar_amount' => 300,
        ], null, AffiliateInfo::class);

        assertSame(100, $type->commissionPerMille);
        assertSame(200, $type->amount);
        assertSame(300, $type->nanostarAmount);
        assertSame(123, $type->affiliateUser->id);
        assertSame(456, $type->affiliateChat->id);
    }
}
