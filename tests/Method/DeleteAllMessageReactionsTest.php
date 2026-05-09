<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\DeleteAllMessageReactions;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteAllMessageReactionsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteAllMessageReactions(1);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteAllMessageReactions', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new DeleteAllMessageReactions(1, 123, 456);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteAllMessageReactions', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'user_id' => 123,
                'actor_chat_id' => 456,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteAllMessageReactions(1);

        $result = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($result);
    }
}
