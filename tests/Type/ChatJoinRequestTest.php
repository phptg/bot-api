<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\ChatInviteLink;
use Phptg\BotApi\Type\ChatJoinRequest;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChatJoinRequestTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $user = new User(1, false, 'Mike');
        $date = new DateTimeImmutable();
        $chatJoinRequest = new ChatJoinRequest($chat, $user, 12, $date);

        assertSame($chat, $chatJoinRequest->chat);
        assertSame($user, $chatJoinRequest->from);
        assertSame(12, $chatJoinRequest->userChatId);
        assertSame($date, $chatJoinRequest->date);
        assertNull($chatJoinRequest->bio);
        assertNull($chatJoinRequest->inviteLink);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'from' => [
                'id' => 2,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'user_chat_id' => 12,
            'date' => 1631840400,
            'bio' => 'Test',
            'invite_link' => [
                'invite_link' => 'https://t.me/joinchat/x1',
                'creator' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Mike',
                ],
                'creates_join_request' => true,
                'is_primary' => false,
                'is_revoked' => false,
            ],
        ];

        $chatJoinRequest = (new ObjectFactory())->create($result, null, ChatJoinRequest::class);

        assertInstanceOf(Chat::class, $chatJoinRequest->chat);
        assertSame(1, $chatJoinRequest->chat->id);

        assertInstanceOf(User::class, $chatJoinRequest->from);
        assertSame(2, $chatJoinRequest->from->id);

        assertSame(12, $chatJoinRequest->userChatId);
        assertSame(1631840400, $chatJoinRequest->date?->getTimestamp());
        assertSame('Test', $chatJoinRequest->bio);

        assertInstanceOf(ChatInviteLink::class, $chatJoinRequest->inviteLink);
        assertSame('https://t.me/joinchat/x1', $chatJoinRequest->inviteLink->inviteLink);
    }
}
