<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\ApproveSuggestedPost;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ApproveSuggestedPostTest extends TestCase
{
    public function testBase(): void
    {
        $method = new ApproveSuggestedPost(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('approveSuggestedPost', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new ApproveSuggestedPost(1, 2, 1234567890);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('approveSuggestedPost', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
                'send_date' => 1234567890,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ApproveSuggestedPost(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
