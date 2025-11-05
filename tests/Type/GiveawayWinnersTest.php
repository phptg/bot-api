<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\GiveawayWinners;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class GiveawayWinnersTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $date = new DateTimeImmutable();
        $user = new User(1, false, 'first_name');
        $giveawayWinners = new GiveawayWinners($chat, 2, $date, 5, [$user]);

        assertSame($chat, $giveawayWinners->chat);
        assertSame(2, $giveawayWinners->giveawayMessageId);
        assertSame($date, $giveawayWinners->winnersSelectionDate);
        assertSame(5, $giveawayWinners->winnerCount);
        assertSame([$user], $giveawayWinners->winners);
        assertNull($giveawayWinners->additionalChatCount);
        assertNull($giveawayWinners->premiumSubscriptionMonthCount);
        assertNull($giveawayWinners->unclaimedPrizeCount);
        assertNull($giveawayWinners->onlyNewMembers);
        assertNull($giveawayWinners->wasRefunded);
        assertNull($giveawayWinners->prizeDescription);
        assertNull($giveawayWinners->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $giveawayWinners = (new ObjectFactory())->create([
            'chat' => ['id' => 1, 'type' => 'private'],
            'giveaway_message_id' => 2,
            'winners_selection_date' => 124125122,
            'winner_count' => 5,
            'winners' => [['id' => 33, 'is_bot' => false, 'first_name' => 'Sergei']],
            'additional_chat_count' => 12,
            'prize_star_count' => 99,
            'premium_subscription_month_count' => 7,
            'unclaimed_prize_count' => 3,
            'only_new_members' => true,
            'was_refunded' => true,
            'prize_description' => 'Desc',
        ], null, GiveawayWinners::class);

        assertSame(1, $giveawayWinners->chat->id);
        assertSame(2, $giveawayWinners->giveawayMessageId);
        assertSame(124125122, $giveawayWinners->winnersSelectionDate->getTimestamp());
        assertSame(5, $giveawayWinners->winnerCount);

        assertCount(1, $giveawayWinners->winners);
        assertSame(33, $giveawayWinners->winners[0]->id);

        assertSame(12, $giveawayWinners->additionalChatCount);
        assertSame(7, $giveawayWinners->premiumSubscriptionMonthCount);
        assertSame(3, $giveawayWinners->unclaimedPrizeCount);
        assertTrue($giveawayWinners->onlyNewMembers);
        assertTrue($giveawayWinners->wasRefunded);
        assertSame('Desc', $giveawayWinners->prizeDescription);
        assertSame(99, $giveawayWinners->prizeStarCount);
    }
}
