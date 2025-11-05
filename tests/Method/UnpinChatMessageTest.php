<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UnpinChatMessage;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class UnpinChatMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnpinChatMessage(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('unpinChatMessage', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new UnpinChatMessage(1, 2, 'bid');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('unpinChatMessage', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bid',
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnpinChatMessage(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
