<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetChatMemberCount;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetChatMemberCountTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetChatMemberCount(1);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getChatMemberCount', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetChatMemberCount(1);

        $preparedResult = TestHelper::createSuccessStubApi(23)->call($method);

        assertSame(23, $preparedResult);
    }
}
