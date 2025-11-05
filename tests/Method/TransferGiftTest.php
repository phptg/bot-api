<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\TransferGift;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class TransferGiftTest extends TestCase
{
    public function testBase(): void
    {
        $method = new TransferGift('bcid1', 'ogid1', 123456789);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('transferGift', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'owned_gift_id' => 'ogid1',
                'new_owner_chat_id' => 123456789,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new TransferGift(
            'business_connection_id',
            'owned_gift_id',
            123456789,
            10,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('transferGift', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'business_connection_id',
                'owned_gift_id' => 'owned_gift_id',
                'new_owner_chat_id' => 123456789,
                'star_count' => 10,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new TransferGift('business_connection_id', 'owned_gift_id', 123456789);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
