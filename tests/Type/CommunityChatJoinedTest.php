<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Community;
use Phptg\BotApi\Type\CommunityChatJoined;

use function PHPUnit\Framework\assertSame;

final class CommunityChatJoinedTest extends TestCase
{
    public function testBase(): void
    {
        $community = new Community(123, 'My Community');
        $communityChatJoined = new CommunityChatJoined($community);

        assertSame($community, $communityChatJoined->community);
    }

    public function testFromTelegramResult(): void
    {
        $communityChatJoined = (new ObjectFactory())->create([
            'community' => [
                'id' => 123,
                'name' => 'My Community',
            ],
        ], null, CommunityChatJoined::class);

        assertSame(123, $communityChatJoined->community->id);
        assertSame('My Community', $communityChatJoined->community->name);
    }
}
