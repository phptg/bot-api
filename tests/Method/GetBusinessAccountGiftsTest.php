<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetBusinessAccountGifts;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\OwnedGifts;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetBusinessAccountGiftsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetBusinessAccountGifts(
            businessConnectionId: 'business_connection_id_123',
        );

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getBusinessAccountGifts', $method->getApiMethod());
        assertSame(
            ['business_connection_id' => 'business_connection_id_123'],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetBusinessAccountGifts(
            'business_connection_id_123',
            true,
            false,
            true,
            false,
            true,
            true,
            'offset_value',
            50,
        );

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getBusinessAccountGifts', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'business_connection_id_123',
                'exclude_unsaved' => true,
                'exclude_saved' => false,
                'exclude_unlimited' => true,
                'exclude_limited' => false,
                'exclude_unique' => true,
                'sort_by_price' => true,
                'offset' => 'offset_value',
                'limit' => 50,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetBusinessAccountGifts(
            businessConnectionId: 'business_connection_id_123',
        );

        $result = TestHelper::createSuccessStubApi([
            'total_count' => 0,
            'gifts' => [],
        ])->call($method);

        assertInstanceOf(OwnedGifts::class, $result);
        assertEmpty($result->gifts);
    }
}
