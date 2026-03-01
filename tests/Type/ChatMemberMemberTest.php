<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatMemberMember;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class ChatMemberMemberTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberMember($user);

        assertSame('member', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
        assertNull($member->tag);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
        ], null, ChatMemberMember::class);

        assertSame(123, $member->user->id);
    }

    public function testFromTelegramResultFull(): void
    {
        $member = (new ObjectFactory())->create(
            [
                'user' => [
                    'id' => 123,
                    'is_bot' => false,
                    'first_name' => 'John',
                ],
                'until_date' => 1724317996,
                'tag' => 'test-tag',
            ],
            null,
            ChatMemberMember::class,
        );

        assertSame(123, $member->user->id);
        assertSame(1724317996, $member->untilDate?->getTimestamp());
        assertSame('test-tag', $member->tag);
    }
}
