<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatInviteLink;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatInviteLinkTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Mike');
        $chatInviteLink = new ChatInviteLink('https://t.me/joinchat/x1', $user, true, false, false);

        assertSame('https://t.me/joinchat/x1', $chatInviteLink->inviteLink);
        assertSame($user, $chatInviteLink->creator);
        assertTrue($chatInviteLink->createsJoinRequest);
        assertFalse($chatInviteLink->isPrimary);
        assertFalse($chatInviteLink->isRevoked);
        assertNull($chatInviteLink->name);
        assertNull($chatInviteLink->expireDate);
        assertNull($chatInviteLink->memberLimit);
        assertNull($chatInviteLink->pendingJoinRequestCount);
        assertNull($chatInviteLink->subscriptionPeriod);
        assertNull($chatInviteLink->subscriptionPrice);
    }

    public function testFromTelegramResult(): void
    {
        $result = [
            'invite_link' => 'https://t.me/joinchat/x1',
            'creator' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
            'creates_join_request' => true,
            'is_primary' => false,
            'is_revoked' => false,
            'name' => 'Test',
            'expire_date' => 1631840400,
            'member_limit' => 100,
            'pending_join_request_count' => 10,
            'subscription_period' => 20,
            'subscription_price' => 30,
        ];

        $chatInviteLink = (new ObjectFactory())->create($result, null, ChatInviteLink::class);

        assertSame('https://t.me/joinchat/x1', $chatInviteLink->inviteLink);
        assertInstanceOf(User::class, $chatInviteLink->creator);
        assertTrue($chatInviteLink->createsJoinRequest);
        assertFalse($chatInviteLink->isPrimary);
        assertFalse($chatInviteLink->isRevoked);
        assertSame('Test', $chatInviteLink->name);
        assertSame(1631840400, $chatInviteLink->expireDate?->getTimestamp());
        assertSame(100, $chatInviteLink->memberLimit);
        assertSame(10, $chatInviteLink->pendingJoinRequestCount);
        assertSame(20, $chatInviteLink->subscriptionPeriod);
        assertSame(30, $chatInviteLink->subscriptionPrice);
    }
}
