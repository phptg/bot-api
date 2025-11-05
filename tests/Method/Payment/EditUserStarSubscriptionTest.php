<?php

declare(strict_types=1);

namespace Method\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Payment\EditUserStarSubscription;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditUserStarSubscriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditUserStarSubscription(1, 'tpcid2', false);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editUserStarSubscription', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'telegram_payment_charge_id' => 'tpcid2',
                'is_canceled' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditUserStarSubscription(1, 'tpcid2', false);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
