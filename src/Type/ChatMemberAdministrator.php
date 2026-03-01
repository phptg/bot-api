<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatmemberadministrator
 *
 * @api
 */
final readonly class ChatMemberAdministrator implements ChatMember
{
    public function __construct(
        public User $user,
        public bool $canBeEdited,
        public bool $isAnonymous,
        public bool $canManageChat,
        public bool $canDeleteMessages,
        public bool $canManageVideoChats,
        public bool $canRestrictMembers,
        public bool $canPromoteMembers,
        public bool $canChangeInfo,
        public bool $canInviteUsers,
        public bool $canPostStories,
        public bool $canEditStories,
        public bool $canDeleteStories,
        public ?bool $canPostMessages = null,
        public ?bool $canEditMessages = null,
        public ?bool $canPinMessages = null,
        public ?bool $canManageTopics = null,
        public ?string $customTitle = null,
        public ?bool $canManageDirectMessages = null,
        public ?bool $canManageTags = null,
    ) {}

    public function getStatus(): string
    {
        return 'administrator';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
