<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SendChatJoinRequestWebApp;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SendChatJoinRequestWebAppTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendChatJoinRequestWebApp('qid1', 'https://example.com/app');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('sendChatJoinRequestWebApp', $method->getApiMethod());
        assertSame(
            [
                'chat_join_request_query_id' => 'qid1',
                'web_app_url' => 'https://example.com/app',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendChatJoinRequestWebApp('qid1', 'https://example.com/app');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
