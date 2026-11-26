<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Method\Update\GetUpdates;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertSame;

final class GetUpdatesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUpdates();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUpdates', $method->getApiMethod());
        assertSame([], $method->getData());
        assertSame(0, $method->getLongPollingTimeout());
    }

    public function testNegativeTimeout(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "timeout" must be a non-negative integer. -1 given.');

        // @phpstan-ignore argument.type (negative timeout is passed on purpose)
        new GetUpdates(timeout: -1);
    }

    public function testFull(): void
    {
        $method = new GetUpdates(
            20,
            10,
            5000,
            ['u1', 'u2'],
        );

        assertSame(
            [
                'offset' => 20,
                'limit' => 10,
                'timeout' => 5000,
                'allowed_updates' => ['u1', 'u2'],
            ],
            $method->getData(),
        );
        assertSame(5000, $method->getLongPollingTimeout());
    }

    public function testPrepareResult(): void
    {
        $method = new GetUpdates();

        $preparedResult = TestHelper::createSuccessStubApi([
            ['update_id' => 1],
            ['update_id' => 2],
        ])->call($method);

        assertIsArray($preparedResult);
        assertCount(2, $preparedResult);
        assertSame(1, $preparedResult[0]->updateId);
        assertSame(2, $preparedResult[1]->updateId);
    }
}
