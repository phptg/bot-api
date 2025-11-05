<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetBusinessAccountStarBalance;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\StarAmount;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetBusinessAccountStarBalanceTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetBusinessAccountStarBalance(
            businessConnectionId: 'business_connection_id_123',
        );

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getBusinessAccountStarBalance', $method->getApiMethod());
        assertSame(
            ['business_connection_id' => 'business_connection_id_123'],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetBusinessAccountStarBalance(
            businessConnectionId: 'business_connection_id_123',
        );

        $result = TestHelper::createSuccessStubApi([
            'amount' => 100,
            'nanostar_amount' => 23000,
        ])->call($method);

        assertInstanceOf(StarAmount::class, $result);
        assertSame(100, $result->amount);
        assertSame(23000, $result->nanostarAmount);
    }
}
