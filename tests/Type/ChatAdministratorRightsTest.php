<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatAdministratorRights;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatAdministratorRightsTest extends TestCase
{
    public function testBase(): void
    {
        $rights = new ChatAdministratorRights(true, true, true, true, true, true, true, true, true, true, false);

        assertTrue($rights->isAnonymous);
        assertTrue($rights->canManageChat);
        assertTrue($rights->canDeleteMessages);
        assertTrue($rights->canManageVideoChats);
        assertTrue($rights->canRestrictMembers);
        assertTrue($rights->canPromoteMembers);
        assertTrue($rights->canChangeInfo);
        assertTrue($rights->canInviteUsers);
        assertTrue($rights->canPostStories);
        assertTrue($rights->canEditStories);
        assertFalse($rights->canDeleteStories);
        assertNull($rights->canPostMessages);
        assertNull($rights->canEditMessages);
        assertNull($rights->canPinMessages);
        assertNull($rights->canManageTopics);
        assertNull($rights->canManageDirectMessages);
        assertNull($rights->canManageTags);

        assertSame(
            [
                'is_anonymous' => true,
                'can_manage_chat' => true,
                'can_delete_messages' => true,
                'can_manage_video_chats' => true,
                'can_restrict_members' => true,
                'can_promote_members' => true,
                'can_change_info' => true,
                'can_invite_users' => true,
                'can_post_stories' => true,
                'can_edit_stories' => true,
                'can_delete_stories' => false,
            ],
            $rights->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
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
            'can_manage_direct_messages' => false,
            'can_manage_tags' => true,
        ], null, ChatAdministratorRights::class);

        assertTrue($type->isAnonymous);
        assertFalse($type->canManageChat);
        assertTrue($type->canDeleteMessages);
        assertTrue($type->canManageVideoChats);
        assertFalse($type->canRestrictMembers);
        assertTrue($type->canPromoteMembers);
        assertTrue($type->canChangeInfo);
        assertTrue($type->canInviteUsers);
        assertTrue($type->canPostStories);
        assertTrue($type->canEditStories);
        assertFalse($type->canDeleteStories);
        assertTrue($type->canPostMessages);
        assertTrue($type->canEditMessages);
        assertFalse($type->canPinMessages);
        assertTrue($type->canManageTopics);
        assertFalse($type->canManageDirectMessages);
        assertTrue($type->canManageTags);
        assertSame(
            [
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
                'can_manage_direct_messages' => false,
                'can_manage_tags' => true,
            ],
            $type->toRequestArray(),
        );
    }
}
