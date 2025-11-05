<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatMemberLeft;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertSame;

final class ChatMemberLeftTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberLeft($user);

        assertSame('left', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ], null, ChatMemberLeft::class);

        assertSame(123, $member->user->id);
    }
}
