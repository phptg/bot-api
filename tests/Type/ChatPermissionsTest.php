<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatPermissions;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatPermissionsTest extends TestCase
{
    public function testBase(): void
    {
        $chatPermissions = new ChatPermissions();

        assertNull($chatPermissions->canSendMessages);
        assertNull($chatPermissions->canSendAudios);
        assertNull($chatPermissions->canSendDocuments);
        assertNull($chatPermissions->canSendPhotos);
        assertNull($chatPermissions->canSendVideos);
        assertNull($chatPermissions->canSendVideoNotes);
        assertNull($chatPermissions->canSendVoiceNotes);
        assertNull($chatPermissions->canSendPolls);
        assertNull($chatPermissions->canSendOtherMessages);
        assertNull($chatPermissions->canAddWebPagePreviews);
        assertNull($chatPermissions->canEditTag);
        assertNull($chatPermissions->canChangeInfo);
        assertNull($chatPermissions->canInviteUsers);
        assertNull($chatPermissions->canPinMessages);
        assertNull($chatPermissions->canManageTopics);
        assertSame([], $chatPermissions->toRequestArray());
    }

    public function testFull(): void
    {
        $chatPermissions = new ChatPermissions(
            true,
            true,
            false,
            false,
            false,
            true,
            true,
            false,
            true,
            true,
            true,
            false,
            false,
            true,
            true,
        );

        assertSame(
            [
                'can_send_messages' => true,
                'can_send_audios' => true,
                'can_send_documents' => false,
                'can_send_photos' => false,
                'can_send_videos' => false,
                'can_send_video_notes' => true,
                'can_send_voice_notes' => true,
                'can_send_polls' => false,
                'can_send_other_messages' => true,
                'can_add_web_page_previews' => true,
                'can_edit_tag' => true,
                'can_change_info' => false,
                'can_invite_users' => false,
                'can_pin_messages' => true,
                'can_manage_topics' => true,
            ],
            $chatPermissions->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $chatPermissions = (new ObjectFactory())->create([
            'can_send_messages' => true,
            'can_send_audios' => false,
            'can_send_documents' => true,
            'can_send_photos' => false,
            'can_send_videos' => true,
            'can_send_video_notes' => true,
            'can_send_voice_notes' => true,
            'can_send_polls' => true,
            'can_send_other_messages' => true,
            'can_add_web_page_previews' => true,
            'can_edit_tag' => true,
            'can_change_info' => true,
            'can_invite_users' => true,
            'can_pin_messages' => true,
            'can_manage_topics' => true,
        ], null, ChatPermissions::class);

        assertTrue($chatPermissions->canSendMessages);
        assertFalse($chatPermissions->canSendAudios);
        assertTrue($chatPermissions->canSendDocuments);
        assertFalse($chatPermissions->canSendPhotos);
        assertTrue($chatPermissions->canSendVideos);
        assertTrue($chatPermissions->canSendVideoNotes);
        assertTrue($chatPermissions->canSendVoiceNotes);
        assertTrue($chatPermissions->canSendPolls);
        assertTrue($chatPermissions->canSendOtherMessages);
        assertTrue($chatPermissions->canAddWebPagePreviews);
        assertTrue($chatPermissions->canEditTag);
        assertTrue($chatPermissions->canChangeInfo);
        assertTrue($chatPermissions->canInviteUsers);
        assertTrue($chatPermissions->canPinMessages);
        assertTrue($chatPermissions->canManageTopics);
    }
}
