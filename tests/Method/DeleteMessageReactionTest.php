<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\DeleteMessageReaction;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteMessageReactionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMessageReaction(1, 100);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMessageReaction', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 100,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new DeleteMessageReaction(1, 100, 123, 456);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMessageReaction', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 100,
                'user_id' => 123,
                'actor_chat_id' => 456,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteMessageReaction(1, 100);

        $result = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($result);
    }
}
