<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\DeleteBusinessAccountGift;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class DeleteBusinessAccountGiftTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteBusinessAccountGift('bcid1', 'ogid2');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteBusinessAccountGift', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'owned_gift_id' => 'ogid2',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteBusinessAccountGift('business_connection_id', 'owned_gift_id');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertSame(true, $preparedResult);
    }
}
