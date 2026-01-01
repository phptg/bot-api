<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\RepostStory;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Type\Story;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class RepostStoryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RepostStory(
            'business_connection_id_123',
            123456,
            789,
            86400,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('repostStory', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'business_connection_id_123',
                'from_chat_id' => 123456,
                'from_story_id' => 789,
                'active_period' => 86400,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new RepostStory(
            'business_connection_id_456',
            654321,
            987,
            21600,
            true,
            true,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('repostStory', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'business_connection_id_456',
                'from_chat_id' => 654321,
                'from_story_id' => 987,
                'active_period' => 21600,
                'post_to_chat_page' => true,
                'protect_content' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RepostStory(
            'business_connection_id_123',
            123456,
            789,
            86400,
        );

        $result = TestHelper::createSuccessStubApi([
            'chat' => [
                'id' => 123,
                'type' => 'private',
            ],
            'id' => 456,
        ])->call($method);

        assertInstanceOf(Story::class, $result);
        assertSame(456, $result->id);
    }
}
