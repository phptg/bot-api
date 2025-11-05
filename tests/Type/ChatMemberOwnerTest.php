<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatMemberOwner;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatMemberOwnerTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberOwner($user, true);

        assertSame('creator', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
        assertTrue($member->isAnonymous);
        assertNull($member->customTitle);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'is_anonymous' => true,
            'custom_title' => 'Custom title',
        ], null, ChatMemberOwner::class);

        assertSame(123, $member->user->id);
        assertTrue($member->isAnonymous);
        assertSame('Custom title', $member->customTitle);
    }
}
