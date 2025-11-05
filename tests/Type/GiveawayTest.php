<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\Giveaway;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class GiveawayTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $date = new DateTimeImmutable();
        $giveaway = new Giveaway([$chat], $date, 3);

        assertSame([$chat], $giveaway->chats);
        assertSame($date, $giveaway->winnersSelectionDate);
        assertSame(3, $giveaway->winnerCount);
        assertNull($giveaway->onlyNewMembers);
        assertNull($giveaway->hasPublicWinners);
        assertNull($giveaway->prizeDescription);
        assertNull($giveaway->countryCodes);
        assertNull($giveaway->premiumSubscriptionMonthCount);
        assertNull($giveaway->prizeStarCount);
    }

    public function testFromTelegramResult(): void
    {
        $giveaway = (new ObjectFactory())->create(
            [
                'chats' => [
                    ['id' => 1, 'type' => 'private'],
                ],
                'winners_selection_date' => 1234567890,
                'winner_count' => 3,
                'only_new_members' => true,
                'has_public_winners' => true,
                'prize_description' => 'prize',
                'country_codes' => ['RU'],
                'prize_star_count' => 19,
                'premium_subscription_month_count' => 7,
            ],
            null,
            Giveaway::class,
        );

        assertCount(1, $giveaway->chats);
        assertInstanceOf(Chat::class, $giveaway->chats[0]);
        assertSame(1, $giveaway->chats[0]->id);
        assertSame('private', $giveaway->chats[0]->type);

        assertSame(1234567890, $giveaway->winnersSelectionDate->getTimestamp());
        assertSame(3, $giveaway->winnerCount);
        assertTrue($giveaway->onlyNewMembers);
        assertTrue($giveaway->hasPublicWinners);
        assertSame('prize', $giveaway->prizeDescription);
        assertSame(['RU'], $giveaway->countryCodes);
        assertSame(7, $giveaway->premiumSubscriptionMonthCount);
        assertSame(19, $giveaway->prizeStarCount);
    }
}
