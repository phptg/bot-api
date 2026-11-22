<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetMySettings;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMySettingsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMySettings();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMySettings', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new SetMySettings(
            true,
            'Ask me...',
            false,
            100,
            true,
            false,
            true,
            false,
            true,
            false,
            true,
            false,
            true,
            false,
            'inline',
        );

        assertSame(
            [
                'supports_inline_queries' => true,
                'inline_query_placeholder' => 'Ask me...',
                'needs_inline_query_location' => false,
                'inline_feedback_share_denominator' => 100,
                'can_join_groups' => true,
                'can_read_all_group_messages' => false,
                'can_connect_to_business' => true,
                'can_manage_bots' => false,
                'supports_guest_queries' => true,
                'supports_join_request_queries' => false,
                'has_topics_enabled' => true,
                'allows_users_to_create_topics' => false,
                'has_topic_sidebar' => true,
                'can_communicate_with_bots' => false,
                'callback_query_mode' => 'inline',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMySettings();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
