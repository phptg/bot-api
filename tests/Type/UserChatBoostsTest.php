<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatBoost;
use Phptg\BotApi\Type\ChatBoostSourcePremium;
use Phptg\BotApi\Type\User;
use Phptg\BotApi\Type\UserChatBoosts;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class UserChatBoostsTest extends TestCase
{
    public function testBase(): void
    {
        $chatBoost = new ChatBoost(
            'b1',
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ChatBoostSourcePremium(new User(1, false, 'Sergei')),
        );
        $type = new UserChatBoosts([$chatBoost]);

        assertSame([$chatBoost], $type->boosts);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'boosts' => [
                [
                    'boost_id' => 'b1',
                    'add_date' => 1619040000,
                    'expiration_date' => 1619040001,
                    'source' => [
                        'source' => 'premium',
                        'user' => [
                            'id' => 1,
                            'is_bot' => false,
                            'first_name' => 'Sergei',
                        ],
                    ],
                ],
            ],
        ], null, UserChatBoosts::class);

        assertCount(1, $type->boosts);
        assertSame('b1', $type->boosts[0]->boostId);
    }
}
