<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatMemberRestricted;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatMemberRestrictedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberRestricted(
            $user,
            true,
            false,
            true,
            false,
            false,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            true,
            false,
        );

        assertSame('restricted', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
        assertTrue($member->isMember);
        assertFalse($member->canSendMessages);
        assertTrue($member->canSendAudios);
        assertFalse($member->canSendDocuments);
        assertFalse($member->canSendPhotos);
        assertTrue($member->canSendVideos);
        assertTrue($member->canSendVideoNotes);
        assertTrue($member->canSendVoiceNotes);
        assertTrue($member->canSendPolls);
        assertTrue($member->canSendOtherMessages);
        assertTrue($member->canAddWebPagePreviews);
        assertTrue($member->canChangeInfo);
        assertTrue($member->canInviteUsers);
        assertTrue($member->canPinMessages);
        assertTrue($member->canManageTopics);
        assertFalse($member->untilDate);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'is_member' => true,
            'can_send_messages' => false,
            'can_send_audios' => true,
            'can_send_documents' => false,
            'can_send_photos' => false,
            'can_send_videos' => false,
            'can_send_video_notes' => true,
            'can_send_voice_notes' => true,
            'can_send_polls' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_pin_messages' => true,
            'can_manage_topics' => true,
            'until_date' => 123456779,
        ], null, ChatMemberRestricted::class);

        assertSame(123, $member->user->id);
        assertTrue($member->isMember);
        assertFalse($member->canSendMessages);
        assertTrue($member->canSendAudios);
        assertFalse($member->canSendDocuments);
        assertFalse($member->canSendPhotos);
        assertFalse($member->canSendVideos);
        assertTrue($member->canSendVideoNotes);
        assertTrue($member->canSendVoiceNotes);
        assertTrue($member->canSendPolls);
        assertTrue($member->canSendOtherMessages);
        assertTrue($member->canAddWebPagePreviews);
        assertTrue($member->canChangeInfo);
        assertTrue($member->canInviteUsers);
        assertTrue($member->canPinMessages);
        assertTrue($member->canManageTopics);
        assertEquals(new DateTimeImmutable('@123456779'), $member->untilDate);
    }

    public function testFromTelegramResultWithZeroUntilDate(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'is_member' => true,
            'can_send_messages' => false,
            'can_send_audios' => true,
            'can_send_documents' => false,
            'can_send_photos' => false,
            'can_send_videos' => false,
            'can_send_video_notes' => true,
            'can_send_voice_notes' => true,
            'can_send_polls' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_pin_messages' => true,
            'can_manage_topics' => true,
            'until_date' => 0,
        ], null, ChatMemberRestricted::class);

        assertSame(123, $member->user->id);
        assertTrue($member->isMember);
        assertFalse($member->canSendMessages);
        assertTrue($member->canSendAudios);
        assertFalse($member->canSendDocuments);
        assertFalse($member->canSendPhotos);
        assertFalse($member->canSendVideos);
        assertTrue($member->canSendVideoNotes);
        assertTrue($member->canSendVoiceNotes);
        assertTrue($member->canSendPolls);
        assertTrue($member->canSendOtherMessages);
        assertTrue($member->canAddWebPagePreviews);
        assertTrue($member->canChangeInfo);
        assertTrue($member->canInviteUsers);
        assertTrue($member->canPinMessages);
        assertTrue($member->canManageTopics);
        assertFalse($member->untilDate);
    }
}
