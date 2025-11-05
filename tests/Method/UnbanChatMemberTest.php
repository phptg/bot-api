<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\UnbanChatMember;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class UnbanChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $method = new UnbanChatMember(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('unbanChatMember', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new UnbanChatMember(1, 2, true);

        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 2,
                'only_if_banned' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UnbanChatMember(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
