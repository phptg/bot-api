<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\VideoChatParticipantsInvited;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;

final class VideoChatParticipantsInvitedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Sergei');
        $videoChatParticipantsInvited = new VideoChatParticipantsInvited([$user]);

        assertSame([$user], $videoChatParticipantsInvited->users);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatParticipantsInvited = (new ObjectFactory())->create([
            'users' => [
                ['id' => 1, 'is_bot' => false, 'first_name' => 'Sergei'],
            ],
        ], null, VideoChatParticipantsInvited::class);

        assertCount(1, $videoChatParticipantsInvited->users);
        assertSame(1, $videoChatParticipantsInvited->users[0]->id);
        assertFalse($videoChatParticipantsInvited->users[0]->isBot);
        assertSame('Sergei', $videoChatParticipantsInvited->users[0]->firstName);
    }
}
