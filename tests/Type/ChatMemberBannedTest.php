<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatMemberBanned;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;

final class ChatMemberBannedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'John');
        $member = new ChatMemberBanned($user, false);

        assertSame('kicked', $member->getStatus());
        assertSame($user, $member->getUser());
        assertSame($user, $member->user);
        assertFalse($member->untilDate);
    }

    public function testFromTelegramResult(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'until_date' => 123456779,
        ], null, ChatMemberBanned::class);

        assertSame(123, $member->user->id);
        assertEquals(new DateTimeImmutable('@123456779'), $member->untilDate);
    }

    public function testFromTelegramResultWithZeroUntilDate(): void
    {
        $member = (new ObjectFactory())->create([
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'until_date' => 0,
        ], null, ChatMemberBanned::class);

        assertSame(123, $member->user->id);
        assertFalse($member->untilDate);
    }
}
