<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\ChatInviteLink;
use Phptg\BotApi\Type\ChatMemberMember;
use Phptg\BotApi\Type\ChatMemberUpdated;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatMemberUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(123, 'group');
        $user = new User(123, false, 'John');
        $date = new DateTimeImmutable();
        $oldChatMember = new ChatMemberMember($user);
        $newChatMember = new ChatMemberMember($user);
        $chatMemberUpdated = new ChatMemberUpdated($chat, $user, $date, $oldChatMember, $newChatMember);

        assertSame($chat, $chatMemberUpdated->chat);
        assertSame($user, $chatMemberUpdated->from);
        assertSame($date, $chatMemberUpdated->date);
        assertSame($oldChatMember, $chatMemberUpdated->oldChatMember);
        assertSame($newChatMember, $chatMemberUpdated->newChatMember);
        assertNull($chatMemberUpdated->inviteLink);
        assertNull($chatMemberUpdated->viaJoinRequest);
        assertNull($chatMemberUpdated->viaChatFolderInviteLink);
    }

    public function testFromTelegramResult(): void
    {
        $chatMemberUpdated = (new ObjectFactory())->create([
            'chat' => [
                'id' => 123,
                'type' => 'group',
            ],
            'from' => [
                'id' => 5,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'date' => 123456779,
            'old_chat_member' => [
                'user' => [
                    'id' => 7,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'status' => 'member',
            ],
            'new_chat_member' => [
                'user' => [
                    'id' => 8,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'status' => 'member',
            ],
            'invite_link' => [
                'invite_link' => 'https://t.me/joinchat/123',
                'creator' => [
                    'id' => 3,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'creates_join_request' => true,
                'is_primary' => true,
                'is_revoked' => false,
            ],
            'via_join_request' => true,
            'via_chat_folder_invite_link' => false,
        ], null, ChatMemberUpdated::class);

        assertSame(123, $chatMemberUpdated->chat->id);
        assertSame(5, $chatMemberUpdated->from->id);
        assertEquals(new DateTimeImmutable('@123456779'), $chatMemberUpdated->date);
        assertSame(7, $chatMemberUpdated->oldChatMember->user->id);
        assertSame(8, $chatMemberUpdated->newChatMember->user->id);

        assertInstanceOf(ChatInviteLink::class, $chatMemberUpdated->inviteLink);
        assertSame('https://t.me/joinchat/123', $chatMemberUpdated->inviteLink->inviteLink);

        assertTrue($chatMemberUpdated->viaJoinRequest);
        assertFalse($chatMemberUpdated->viaChatFolderInviteLink);
    }
}
