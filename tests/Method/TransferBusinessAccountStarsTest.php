<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\TransferBusinessAccountStars;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class TransferBusinessAccountStarsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new TransferBusinessAccountStars('connection1', 100);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('transferBusinessAccountStars', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection1',
                'star_count' => 100,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new TransferBusinessAccountStars('connection1', 100);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
