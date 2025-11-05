<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\CreateForumTopic;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class CreateForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CreateForumTopic(1, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createForumTopic', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'name' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new CreateForumTopic(1, 'test', 0x6FB9F0, '2135123');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('createForumTopic', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'name' => 'test',
                'icon_color' => 0x6FB9F0,
                'icon_custom_emoji_id' => '2135123',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CreateForumTopic(1, 'test');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_thread_id' => 19,
            'name' => 'test',
            'icon_color' => 0x00FF00,
            'icon_custom_emoji_id' => '2351346235143',
        ])->call($method);

        assertSame(19, $preparedResult->messageThreadId);
    }
}
