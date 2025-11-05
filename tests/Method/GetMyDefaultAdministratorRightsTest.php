<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\GetMyDefaultAdministratorRights;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class GetMyDefaultAdministratorRightsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyDefaultAdministratorRights();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyDefaultAdministratorRights', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetMyDefaultAdministratorRights(true);

        assertSame(
            [
                'for_channels' => true,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyDefaultAdministratorRights();

        $preparedResult = TestHelper::createSuccessStubApi([
            'is_anonymous' => true,
            'can_manage_chat' => false,
            'can_delete_messages' => true,
            'can_manage_video_chats' => true,
            'can_restrict_members' => false,
            'can_promote_members' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_post_stories' => true,
            'can_edit_stories' => true,
            'can_delete_stories' => false,
            'can_post_messages' => true,
            'can_edit_messages' => true,
            'can_pin_messages' => false,
            'can_manage_topics' => true,
        ])->call($method);

        assertTrue($preparedResult->isAnonymous);
        assertFalse($preparedResult->canManageChat);
        assertTrue($preparedResult->canDeleteMessages);
        assertTrue($preparedResult->canManageVideoChats);
        assertFalse($preparedResult->canRestrictMembers);
        assertTrue($preparedResult->canPromoteMembers);
        assertTrue($preparedResult->canChangeInfo);
        assertTrue($preparedResult->canInviteUsers);
        assertTrue($preparedResult->canPostStories);
        assertTrue($preparedResult->canEditStories);
        assertFalse($preparedResult->canDeleteStories);
        assertTrue($preparedResult->canPostMessages);
        assertTrue($preparedResult->canEditMessages);
        assertFalse($preparedResult->canPinMessages);
        assertTrue($preparedResult->canManageTopics);
    }
}
