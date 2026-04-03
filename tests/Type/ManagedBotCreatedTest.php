<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\ManagedBotCreated;
use Phptg\BotApi\Type\User;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class ManagedBotCreatedTest extends TestCase
{
    public function testBase(): void
    {
        $bot = new User(1, true, 'TestBot');
        $managedBotCreated = new ManagedBotCreated($bot);

        assertSame($bot, $managedBotCreated->bot);
    }

    public function testFromTelegramResult(): void
    {
        $managedBotCreated = (new ObjectFactory())->create([
            'bot' => [
                'id' => 1,
                'is_bot' => true,
                'first_name' => 'TestBot',
                'last_name' => 'Bot',
            ],
        ], null, ManagedBotCreated::class);

        assertInstanceOf(ManagedBotCreated::class, $managedBotCreated);
        assertInstanceOf(User::class, $managedBotCreated->bot);
        assertSame(1, $managedBotCreated->bot->id);
        assertSame(true, $managedBotCreated->bot->isBot);
        assertSame('TestBot', $managedBotCreated->bot->firstName);
        assertSame('Bot', $managedBotCreated->bot->lastName);
    }
}
