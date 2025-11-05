<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\ChatBoost;
use Phptg\BotApi\Type\ChatBoostSourcePremium;
use Phptg\BotApi\Type\ChatBoostUpdated;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatBoostUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $chatBoost = new ChatBoost(
            'b1',
            new DateTimeImmutable(),
            new DateTimeImmutable(),
            new ChatBoostSourcePremium(
                new User(123, false, 'John'),
            ),
        );
        $chatBoostUpdated = new ChatBoostUpdated($chat, $chatBoost);

        assertSame($chat, $chatBoostUpdated->chat);
        assertSame($chatBoost, $chatBoostUpdated->boost);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoostUpdated = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'boost' => [
                'boost_id' => 'b1',
                'add_date' => 1630000000,
                'expiration_date' => 1630000001,
                'source' => [
                    'source' => 'premium',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
        ], null, ChatBoostUpdated::class);

        assertSame(1, $chatBoostUpdated->chat->id);
        assertSame('private', $chatBoostUpdated->chat->type);

        assertSame('b1', $chatBoostUpdated->boost->boostId);
        assertSame(1630000000, $chatBoostUpdated->boost->addDate->getTimestamp());
        assertSame(1630000001, $chatBoostUpdated->boost->expirationDate->getTimestamp());
        assertInstanceOf(ChatBoostSourcePremium::class, $chatBoostUpdated->boost->source);
        assertSame(123, $chatBoostUpdated->boost->source->user->id);
    }
}
