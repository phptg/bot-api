<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BotFullInfo;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class BotFullInfoTest extends TestCase
{
    public function testBase(): void
    {
        $botFullInfo = new BotFullInfo(
            1,
            true,
            'My Bot',
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
            true,
            false,
        );

        assertSame(1, $botFullInfo->id);
        assertSame('My Bot', $botFullInfo->firstName);
        assertSame(true, $botFullInfo->canJoinGroups);
        assertSame(false, $botFullInfo->canReadAllGroupMessages);
        assertSame(true, $botFullInfo->supportsGuestQueries);
        assertSame(false, $botFullInfo->supportsInlineQueries);
        assertSame(true, $botFullInfo->needsInlineQueryLocation);
        assertSame(false, $botFullInfo->canConnectToBusiness);
        assertSame(true, $botFullInfo->hasMainWebApp);
        assertSame(false, $botFullInfo->hasTopicsEnabled);
        assertSame(true, $botFullInfo->allowsUsersToCreateTopics);
        assertSame(false, $botFullInfo->hasTopicSidebar);
        assertSame(true, $botFullInfo->canManageBots);
        assertSame(false, $botFullInfo->supportsJoinRequestQueries);
        assertNull($botFullInfo->username);
        assertNull($botFullInfo->activeUsernames);
        assertNull($botFullInfo->inlineQueryPlaceholder);
    }

    public function testFull(): void
    {
        $botFullInfo = new BotFullInfo(
            1,
            true,
            'My Bot',
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
            true,
            false,
            'my_bot',
            ['my_bot', 'my_bot_2'],
            'Type a query...',
        );

        assertSame(1, $botFullInfo->id);
        assertSame('My Bot', $botFullInfo->firstName);
        assertSame('my_bot', $botFullInfo->username);
        assertSame(['my_bot', 'my_bot_2'], $botFullInfo->activeUsernames);
        assertSame('Type a query...', $botFullInfo->inlineQueryPlaceholder);
    }

    public function testFromTelegramResult(): void
    {
        $botFullInfo = (new ObjectFactory())->create([
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
        ], null, BotFullInfo::class);

        assertSame(1, $botFullInfo->id);
        assertSame('My Bot', $botFullInfo->firstName);
        assertSame(true, $botFullInfo->canJoinGroups);
        assertNull($botFullInfo->username);
        assertNull($botFullInfo->activeUsernames);
        assertNull($botFullInfo->inlineQueryPlaceholder);
    }

    public function testFromTelegramResultFull(): void
    {
        $botFullInfo = (new ObjectFactory())->create([
            'id' => 1,
            'is_bot' => true,
            'first_name' => 'My Bot',
            'username' => 'my_bot',
            'active_usernames' => ['my_bot', 'my_bot_2'],
            'can_join_groups' => true,
            'can_read_all_group_messages' => false,
            'supports_guest_queries' => true,
            'supports_inline_queries' => false,
            'inline_query_placeholder' => 'Type a query...',
            'needs_inline_query_location' => true,
            'can_connect_to_business' => false,
            'has_main_web_app' => true,
            'has_topics_enabled' => false,
            'allows_users_to_create_topics' => true,
            'has_topic_sidebar' => false,
            'can_manage_bots' => true,
            'supports_join_request_queries' => false,
        ], null, BotFullInfo::class);

        assertSame(1, $botFullInfo->id);
        assertSame('My Bot', $botFullInfo->firstName);
        assertSame('my_bot', $botFullInfo->username);
        assertSame(['my_bot', 'my_bot_2'], $botFullInfo->activeUsernames);
        assertSame('Type a query...', $botFullInfo->inlineQueryPlaceholder);
        assertSame(false, $botFullInfo->supportsJoinRequestQueries);
    }
}
