<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\ChatMember;
use Phptg\BotApi\Type\ChatMemberAdministrator;
use Phptg\BotApi\Type\ChatMemberBanned;
use Phptg\BotApi\Type\ChatMemberLeft;
use Phptg\BotApi\Type\ChatMemberMember;
use Phptg\BotApi\Type\ChatMemberOwner;
use Phptg\BotApi\Type\ChatMemberRestricted;

/**
 * @template-extends InterfaceValue<ChatMember>
 */
final readonly class ChatMemberValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'status';
    }

    public function getClassMap(): array
    {
        return [
            'creator' => ChatMemberOwner::class,
            'administrator' => ChatMemberAdministrator::class,
            'member' => ChatMemberMember::class,
            'restricted' => ChatMemberRestricted::class,
            'left' => ChatMemberLeft::class,
            'kicked' => ChatMemberBanned::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown chat member status.';
    }
}
