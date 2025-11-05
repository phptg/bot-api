<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UpgradeGift;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class UpgradeGiftTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UpgradeGift('bcid1', 'ogid1');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('upgradeGift', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'owned_gift_id' => 'ogid1',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new UpgradeGift(
            'business_connection_id',
            'owned_gift_id',
            true,
            10,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('upgradeGift', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'business_connection_id',
                'owned_gift_id' => 'owned_gift_id',
                'keep_original_details' => true,
                'star_count' => 10,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UpgradeGift('business_connection_id', 'owned_gift_id');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
