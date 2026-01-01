<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetUserGifts;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\OwnedGifts;

use function PHPUnit\Framework\assertEmpty;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetUserGiftsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserGifts(userId: 12345);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUserGifts', $method->getApiMethod());
        assertSame(
            ['user_id' => 12345],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetUserGifts(
            12345,
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
        assertSame('getUserGifts', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 12345,
                'exclude_unlimited' => true,
                'exclude_limited_upgradable' => false,
                'exclude_limited_non_upgradable' => true,
                'exclude_from_blockchain' => false,
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
        $method = new GetUserGifts(userId: 12345);

        $result = TestHelper::createSuccessStubApi([
            'total_count' => 0,
            'gifts' => [],
        ])->call($method);

        assertInstanceOf(OwnedGifts::class, $result);
        assertEmpty($result->gifts);
    }
}
