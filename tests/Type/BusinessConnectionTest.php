<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BusinessBotRights;
use Phptg\BotApi\Type\BusinessConnection;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class BusinessConnectionTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'Sergei');
        $date = new DateTimeImmutable();
        $businessConnection = new BusinessConnection(
            'id1',
            $user,
            23,
            $date,
            false,
        );

        assertSame('id1', $businessConnection->id);
        assertSame($user, $businessConnection->user);
        assertSame(23, $businessConnection->userChatId);
        assertSame($date, $businessConnection->date);
        assertFalse($businessConnection->isEnabled);
        assertNull($businessConnection->rights);
    }

    public function testFull(): void
    {
        $user = new User(123, false, 'Sergei');
        $date = new DateTimeImmutable();
        $rights = new BusinessBotRights();
        $businessConnection = new BusinessConnection(
            'id1',
            $user,
            23,
            $date,
            false,
            $rights,
        );

        assertSame('id1', $businessConnection->id);
        assertSame($user, $businessConnection->user);
        assertSame(23, $businessConnection->userChatId);
        assertSame($date, $businessConnection->date);
        assertFalse($businessConnection->isEnabled);
        assertSame($rights, $businessConnection->rights);
    }

    public function testFromTelegramResult(): void
    {
        $businessConnection = (new ObjectFactory())->create([
            'id' => 'id1',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'user_chat_id' => 23,
            'date' => 1717517779,
            'is_enabled' => false,
            'rights' => [
                'can_edit_bio' => true,
            ],
        ], null, BusinessConnection::class);

        assertSame('id1', $businessConnection->id);
        assertSame(123, $businessConnection->user->id);
        assertSame(23, $businessConnection->userChatId);
        assertSame(1717517779, $businessConnection->date->getTimestamp());
        assertInstanceOf(BusinessBotRights::class, $businessConnection->rights);
        assertFalse($businessConnection->isEnabled);
        assertTrue($businessConnection->rights->canEditBio);
    }
}
