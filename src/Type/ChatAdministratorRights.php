<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#chatadministratorrights
 *
 * @api
 */
final readonly class ChatAdministratorRights
{
    public function __construct(
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
        public ?bool $canManageDirectMessages = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'is_anonymous' => $this->isAnonymous,
                'can_manage_chat' => $this->canManageChat,
                'can_delete_messages' => $this->canDeleteMessages,
                'can_manage_video_chats' => $this->canManageVideoChats,
                'can_restrict_members' => $this->canRestrictMembers,
                'can_promote_members' => $this->canPromoteMembers,
                'can_change_info' => $this->canChangeInfo,
                'can_invite_users' => $this->canInviteUsers,
                'can_post_stories' => $this->canPostStories,
                'can_edit_stories' => $this->canEditStories,
                'can_delete_stories' => $this->canDeleteStories,
                'can_post_messages' => $this->canPostMessages,
                'can_edit_messages' => $this->canEditMessages,
                'can_pin_messages' => $this->canPinMessages,
                'can_manage_topics' => $this->canManageTopics,
                'can_manage_direct_messages' => $this->canManageDirectMessages,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
