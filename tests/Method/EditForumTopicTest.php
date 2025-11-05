<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\EditForumTopic;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditForumTopic(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editForumTopic', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new EditForumTopic(1, 2, 'test', '2135123');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editForumTopic', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 2,
                'name' => 'test',
                'icon_custom_emoji_id' => '2135123',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditForumTopic(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
