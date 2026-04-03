<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ManagedBotUpdated;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ManagedBotUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'John');
        $bot = new User(2, true, 'TestBot');
        $managedBotUpdated = new ManagedBotUpdated($user, $bot);

        assertSame($user, $managedBotUpdated->user);
        assertSame($bot, $managedBotUpdated->bot);
    }

    public function testFromTelegramResult(): void
    {
        $managedBotUpdated = (new ObjectFactory())->create([
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'John',
                'last_name' => 'Doe',
            ],
            'bot' => [
                'id' => 2,
                'is_bot' => true,
                'first_name' => 'TestBot',
                'username' => 'test_bot',
            ],
        ], null, ManagedBotUpdated::class);

        assertInstanceOf(ManagedBotUpdated::class, $managedBotUpdated);
        assertInstanceOf(User::class, $managedBotUpdated->user);
        assertSame(1, $managedBotUpdated->user->id);
        assertSame(false, $managedBotUpdated->user->isBot);
        assertSame('John', $managedBotUpdated->user->firstName);
        assertSame('Doe', $managedBotUpdated->user->lastName);
        assertInstanceOf(User::class, $managedBotUpdated->bot);
        assertSame(2, $managedBotUpdated->bot->id);
        assertSame(true, $managedBotUpdated->bot->isBot);
        assertSame('TestBot', $managedBotUpdated->bot->firstName);
        assertSame('test_bot', $managedBotUpdated->bot->username);
    }
}
