<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#businessbotrights
 *
 * @api
 */
final readonly class BusinessBotRights
{
    public function __construct(
        public ?true $canReply = null,
        public ?true $canReadMessages = null,
        public ?true $canDeleteOutgoingMessages = null,
        public ?true $canDeleteAllMessages = null,
        public ?true $canEditName = null,
        public ?true $canEditBio = null,
        public ?true $canEditProfilePhoto = null,
        public ?true $canEditUsername = null,
        public ?true $canChangeGiftSettings = null,
        public ?true $canViewGiftsAndStars = null,
        public ?true $canConvertGiftsToStars = null,
        public ?true $canTransferAndUpgradeGifts = null,
        public ?true $canTransferStars = null,
        public ?true $canManageStories = null,
    ) {}
}
