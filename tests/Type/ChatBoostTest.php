<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ChatBoost;
use Phptg\BotApi\Type\ChatBoostSourcePremium;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatBoostTest extends TestCase
{
    public function testBase(): void
    {
        $addDate = new DateTimeImmutable();
        $expirationDate = new DateTimeImmutable();
        $chatBoostSource = new ChatBoostSourcePremium(new User(1, false, 'Sergei'));
        $chatBoost = new ChatBoost('b1', $addDate, $expirationDate, $chatBoostSource);

        assertSame('b1', $chatBoost->boostId);
        assertSame($addDate, $chatBoost->addDate);
        assertSame($expirationDate, $chatBoost->expirationDate);
        assertSame($chatBoostSource, $chatBoost->source);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoost = (new ObjectFactory())->create([
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
        ], null, ChatBoost::class);

        assertSame('b1', $chatBoost->boostId);
        assertEquals(new DateTimeImmutable('@1619040000'), $chatBoost->addDate);
        assertEquals(new DateTimeImmutable('@1619040001'), $chatBoost->expirationDate);

        assertInstanceOf(ChatBoostSourcePremium::class, $chatBoost->source);
        assertSame(1, $chatBoost->source->user->id);
        assertFalse($chatBoost->source->user->isBot);
        assertSame('Sergei', $chatBoost->source->user->firstName);
    }
}
