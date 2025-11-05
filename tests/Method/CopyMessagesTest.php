<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\CopyMessages;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\MessageId;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class CopyMessagesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CopyMessages(1, 2, [3, 4]);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('copyMessages', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'from_chat_id' => 2,
                'message_ids' => [3, 4],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new CopyMessages(1, 2, [3, 4], 5, true, false, true, 123);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('copyMessages', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 5,
                'direct_messages_topic_id' => 123,
                'from_chat_id' => 2,
                'message_ids' => [3, 4],
                'disable_notification' => true,
                'protect_content' => false,
                'remove_caption' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CopyMessages(1, 2, [3, 4]);

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'message_id' => 7,
            ],
            [
                'message_id' => 8,
            ],
        ])->call($method);

        assertCount(2, $preparedResult);
        assertInstanceOf(MessageId::class, $preparedResult[0]);
        assertInstanceOf(MessageId::class, $preparedResult[1]);
        assertSame(7, $preparedResult[0]->messageId);
        assertSame(8, $preparedResult[1]->messageId);
    }
}
