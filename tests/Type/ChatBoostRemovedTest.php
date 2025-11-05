<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Chat;
use Phptg\BotApi\Type\ChatBoostRemoved;
use Phptg\BotApi\Type\ChatBoostSourcePremium;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ChatBoostRemovedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $removeDate = new DateTimeImmutable();
        $source = new ChatBoostSourcePremium(new User(1, false, 'Sergei'));
        $chatBoostRemoved = new ChatBoostRemoved($chat, 'b1', $removeDate, $source);

        assertSame($chat, $chatBoostRemoved->chat);
        assertSame('b1', $chatBoostRemoved->boostId);
        assertSame($removeDate, $chatBoostRemoved->removeDate);
        assertSame($source, $chatBoostRemoved->source);
    }

    public function testFromTelegramResult(): void
    {
        $chatBoostRemoved = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'boost_id' => 'b1',
            'remove_date' => 1619040000,
            'source' => [
                'source' => 'premium',
                'user' => [
                    'id' => 1,
                    'is_bot' => false,
                    'first_name' => 'Sergei',
                ],
            ],
        ], null, ChatBoostRemoved::class);

        assertSame(1, $chatBoostRemoved->chat->id);
        assertSame('private', $chatBoostRemoved->chat->type);

        assertSame('b1', $chatBoostRemoved->boostId);
        assertEquals(new DateTimeImmutable('@1619040000'), $chatBoostRemoved->removeDate);

        assertInstanceOf(ChatBoostSourcePremium::class, $chatBoostRemoved->source);
        assertSame(1, $chatBoostRemoved->source->user->id);
        assertFalse($chatBoostRemoved->source->user->isBot);
        assertSame('Sergei', $chatBoostRemoved->source->user->firstName);
    }
}
