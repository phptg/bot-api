<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatmemberupdated
 *
 * @api
 */
final readonly class ChatMemberUpdated
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public DateTimeImmutable $date,
        public ChatMember $oldChatMember,
        public ChatMember $newChatMember,
        public ?ChatInviteLink $inviteLink = null,
        public ?bool $viaJoinRequest = null,
        public ?bool $viaChatFolderInviteLink = null,
    ) {}
}
