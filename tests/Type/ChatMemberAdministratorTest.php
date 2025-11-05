<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatMemberAdministrator;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatMemberAdministratorTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberAdministrator(
            $user,
            true,
            false,
            false,
            true,
            true,
            true,
            true,
            true,
            false,
            true,
            true,
            true,
        );

        assertSame('administrator', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
        assertTrue($member->canBeEdited);
        assertFalse($member->isAnonymous);
        assertFalse($member->canManageChat);
        assertTrue($member->canDeleteMessages);
        assertTrue($member->canManageVideoChats);
        assertTrue($member->canRestrictMembers);
        assertTrue($member->canPromoteMembers);
        assertTrue($member->canChangeInfo);
        assertFalse($member->canInviteUsers);
        assertTrue($member->canPostStories);
        assertTrue($member->canEditStories);
        assertTrue($member->canDeleteStories);
        assertNull($member->canPostMessages);
        assertNull($member->canEditMessages);
        assertNull($member->canPinMessages);
        assertNull($member->canManageTopics);
        assertNull($member->customTitle);
        assertNull($member->canManageDirectMessages);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'can_be_edited' => true,
            'is_anonymous' => false,
            'can_manage_chat' => false,
            'can_delete_messages' => true,
            'can_manage_video_chats' => true,
            'can_restrict_members' => true,
            'can_promote_members' => true,
            'can_change_info' => true,
            'can_invite_users' => false,
            'can_post_stories' => true,
            'can_edit_stories' => true,
            'can_delete_stories' => true,
            'can_post_messages' => true,
            'can_edit_messages' => false,
            'can_pin_messages' => true,
            'can_manage_topics' => false,
            'can_manage_direct_messages' => true,
            'custom_title' => 'Custom title',
        ], null, ChatMemberAdministrator::class);

        assertSame(123, $member->user->id);
        assertTrue($member->canBeEdited);
        assertFalse($member->isAnonymous);
        assertFalse($member->canManageChat);
        assertTrue($member->canDeleteMessages);
        assertTrue($member->canManageVideoChats);
        assertTrue($member->canRestrictMembers);
        assertTrue($member->canPromoteMembers);
        assertTrue($member->canChangeInfo);
        assertFalse($member->canInviteUsers);
        assertTrue($member->canPostStories);
        assertTrue($member->canEditStories);
        assertTrue($member->canDeleteStories);
        assertTrue($member->canPostMessages);
        assertFalse($member->canEditMessages);
        assertTrue($member->canPinMessages);
        assertFalse($member->canManageTopics);
        assertSame('Custom title', $member->customTitle);
        assertTrue($member->canManageDirectMessages);
    }
}
