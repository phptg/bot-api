<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\Payment\GetStarTransactions;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetStarTransactionsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetStarTransactions();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getStarTransactions', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetStarTransactions(10, 100);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getStarTransactions', $method->getApiMethod());
        assertSame([
            'offset' => 10,
            'limit' => 100,
        ], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetStarTransactions(99);

        $preparedResult = TestHelper::createSuccessStubApi([
            'transactions' => [],
        ])->call($method);

        assertSame([], $preparedResult->transactions);
    }
}
