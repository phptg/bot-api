<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetUserPersonalChatMessages;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\Message;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertIsArray;
use function PHPUnit\Framework\assertSame;

final class GetUserPersonalChatMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserPersonalChatMessages(123, 10);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getUserPersonalChatMessages', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 123,
                'limit' => 10,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUserPersonalChatMessages(123, 10);

        $result = TestHelper::createSuccessStubApi([
            [
                'message_id' => 1,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
            [
                'message_id' => 2,
                'date' => 1620000001,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ])->call($method);

        assertIsArray($result);
        assertCount(2, $result);
        assertInstanceOf(Message::class, $result[0]);
        assertSame(1, $result[0]->messageId);
        assertInstanceOf(Message::class, $result[1]);
        assertSame(2, $result[1]->messageId);
    }
}
