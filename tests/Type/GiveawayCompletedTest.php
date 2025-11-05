<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\GiveawayCompleted;
use Phptg\BotApi\Type\Message;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class GiveawayCompletedTest extends TestCase
{
    public function testBase(): void
    {
        $giveawayCompleted = new GiveawayCompleted(3);

        assertSame(3, $giveawayCompleted->winnerCount);
        assertNull($giveawayCompleted->unclaimedPrizeCount);
        assertNull($giveawayCompleted->giveawayMessage);
    }

    public function testFromTelegramResult(): void
    {
        $giveawayCompleted = (new ObjectFactory())->create(
            [
                'winner_count' => 3,
                'unclaimed_prize_count' => 2,
                'giveaway_message' => [
                    'message_id' => 123,
                    'date' => 1717501903,
                    'chat' => [
                        'id' => 23,
                        'type' => 'private',
                    ],
                ],
                'is_star_giveaway' => true,
            ],
            null,
            GiveawayCompleted::class,
        );

        assertSame(3, $giveawayCompleted->winnerCount);
        assertSame(2, $giveawayCompleted->unclaimedPrizeCount);

        assertInstanceOf(Message::class, $giveawayCompleted->giveawayMessage);
        assertSame(123, $giveawayCompleted->giveawayMessage->messageId);
        assertTrue($giveawayCompleted->isStarGiveaway);
    }
}
