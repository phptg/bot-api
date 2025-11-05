<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\RemoveUserVerification;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveUserVerificationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveUserVerification(7);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeUserVerification', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveUserVerification(5);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
