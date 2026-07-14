<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Community;
use Phptg\BotApi\Type\CommunityChatAdded;

use function PHPUnit\Framework\assertSame;

final class CommunityChatAddedTest extends TestCase
{
    public function testBase(): void
    {
        $community = new Community(123, 'My Community');
        $communityChatAdded = new CommunityChatAdded($community);

        assertSame($community, $communityChatAdded->community);
    }

    public function testFromTelegramResult(): void
    {
        $communityChatAdded = (new ObjectFactory())->create([
            'community' => [
                'id' => 123,
                'name' => 'My Community',
            ],
        ], null, CommunityChatAdded::class);

        assertSame(123, $communityChatAdded->community->id);
        assertSame('My Community', $communityChatAdded->community->name);
    }
}
