<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetMe;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\BotFullInfo;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetMeTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMe();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMe', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetMe();

        $preparedResult = TestHelper::createSuccessStubApi([
            'id' => 1,
            'is_bot' => true,
            'first_name' => 'My Bot',
            'can_join_groups' => true,
            'can_read_all_group_messages' => false,
            'supports_guest_queries' => true,
            'supports_inline_queries' => false,
            'needs_inline_query_location' => true,
            'can_connect_to_business' => false,
            'has_main_web_app' => true,
            'has_topics_enabled' => false,
            'allows_users_to_create_topics' => true,
            'has_topic_sidebar' => false,
            'can_manage_bots' => true,
            'supports_join_request_queries' => false,
        ])->call($method);

        assertInstanceOf(BotFullInfo::class, $preparedResult);
        assertSame(1, $preparedResult->id);
    }
}
