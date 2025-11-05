<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessBotRights;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertTrue;

final class BusinessBotRightsTest extends TestCase
{
    public function testEmptyConstructor(): void
    {
        $rights = new BusinessBotRights();

        assertNull($rights->canReply);
        assertNull($rights->canReadMessages);
        assertNull($rights->canDeleteOutgoingMessages);
        assertNull($rights->canDeleteAllMessages);
        assertNull($rights->canEditName);
        assertNull($rights->canEditBio);
        assertNull($rights->canEditProfilePhoto);
        assertNull($rights->canEditUsername);
        assertNull($rights->canChangeGiftSettings);
        assertNull($rights->canViewGiftsAndStars);
        assertNull($rights->canConvertGiftsToStars);
        assertNull($rights->canTransferAndUpgradeGifts);
        assertNull($rights->canTransferStars);
        assertNull($rights->canManageStories);
    }

    public function testAllValues(): void
    {
        $rights = new BusinessBotRights(
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
            true,
            true,
            true,
            true,
        );

        assertTrue($rights->canReply);
        assertTrue($rights->canReadMessages);
        assertTrue($rights->canDeleteOutgoingMessages);
        assertTrue($rights->canDeleteAllMessages);
        assertTrue($rights->canEditName);
        assertTrue($rights->canEditBio);
        assertTrue($rights->canEditProfilePhoto);
        assertTrue($rights->canEditUsername);
        assertTrue($rights->canChangeGiftSettings);
        assertTrue($rights->canViewGiftsAndStars);
        assertTrue($rights->canConvertGiftsToStars);
        assertTrue($rights->canTransferAndUpgradeGifts);
        assertTrue($rights->canTransferStars);
        assertTrue($rights->canManageStories);
    }

    public function testFromTelegramResult(): void
    {
        $businessBotRights = (new ObjectFactory())->create([
            'can_reply' => true,
            'can_read_messages' => true,
            'can_delete_outgoing_messages' => true,
            'can_delete_all_messages' => true,
            'can_edit_name' => true,
            'can_edit_bio' => true,
            'can_edit_profile_photo' => true,
            'can_edit_username' => true,
            'can_change_gift_settings' => true,
            'can_view_gifts_and_stars' => true,
            'can_convert_gifts_to_stars' => true,
            'can_transfer_and_upgrade_gifts' => true,
            'can_transfer_stars' => true,
            'can_manage_stories' => true,
        ], null, BusinessBotRights::class);

        assertTrue($businessBotRights->canReply);
        assertTrue($businessBotRights->canReadMessages);
        assertTrue($businessBotRights->canDeleteOutgoingMessages);
        assertTrue($businessBotRights->canDeleteAllMessages);
        assertTrue($businessBotRights->canEditName);
        assertTrue($businessBotRights->canEditBio);
        assertTrue($businessBotRights->canEditProfilePhoto);
        assertTrue($businessBotRights->canEditUsername);
        assertTrue($businessBotRights->canChangeGiftSettings);
        assertTrue($businessBotRights->canViewGiftsAndStars);
        assertTrue($businessBotRights->canConvertGiftsToStars);
        assertTrue($businessBotRights->canTransferAndUpgradeGifts);
        assertTrue($businessBotRights->canTransferStars);
        assertTrue($businessBotRights->canManageStories);
    }
}
