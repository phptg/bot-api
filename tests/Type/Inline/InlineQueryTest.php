<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Inline\InlineQuery;
use Phptg\BotApi\Type\Location;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class InlineQueryTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'first_name');
        $inlineQuery = new InlineQuery(
            'id1',
            $user,
            'query1',
            'offset2',
        );

        assertSame('id1', $inlineQuery->id);
        assertSame($user, $inlineQuery->from);
        assertSame('query1', $inlineQuery->query);
        assertSame('offset2', $inlineQuery->offset);
        assertNull($inlineQuery->chatType);
        assertNull($inlineQuery->location);
    }

    public function testFromTelegramResult(): void
    {
        $inlineQuery = (new ObjectFactory())->create([
            'id' => 'id1',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'user1',
            ],
            'query' => 'query1',
            'offset' => 'offset2',
            'chat_type' => 'channel',
            'location' => [
                'latitude' => 1.2,
                'longitude' => 3.4,
            ],
        ], null, InlineQuery::class);

        assertSame('id1', $inlineQuery->id);

        assertSame(1, $inlineQuery->from->id);
        assertSame(false, $inlineQuery->from->isBot);
        assertSame('user1', $inlineQuery->from->firstName);

        assertSame('query1', $inlineQuery->query);
        assertSame('offset2', $inlineQuery->offset);
        assertSame('channel', $inlineQuery->chatType);

        assertInstanceOf(Location::class, $inlineQuery->location);
        assertSame(1.2, $inlineQuery->location->latitude);
        assertSame(3.4, $inlineQuery->location->longitude);
    }
}
