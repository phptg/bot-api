<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\RemoveChatVerification;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveChatVerificationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveChatVerification(7);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeChatVerification', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 7,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveChatVerification('id5');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
