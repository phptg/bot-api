<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatBoostSourceGiveaway;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ChatBoostSourceGiveawayTest extends TestCase
{
    public function testBase(): void
    {
        $source = new ChatBoostSourceGiveaway(12);

        assertSame('giveaway', $source->getSource());
        assertNull($source->getUser());
        assertSame(12, $source->giveawayMessageId);
        assertNull($source->user);
        assertNull($source->isUnclaimed);
        assertNull($source->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $source = (new ObjectFactory())->create(
            [
                'source' => 'giveaway',
                'giveaway_message_id' => 12,
                'user' => [
                    'id' => 7,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
                'prize_star_count' => 19,
                'is_unclaimed' => true,
            ],
            null,
            ChatBoostSourceGiveaway::class,
        );

        assertSame(12, $source->giveawayMessageId);

        assertInstanceOf(User::class, $source->user);
        assertSame(7, $source->user->id);

        assertTrue($source->isUnclaimed);
        assertSame(19, $source->prizeStarCount);
    }
}
