<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\RichTextBotCommand;

use function PHPUnit\Framework\assertSame;

final class RichTextBotCommandTest extends TestCase
{
    public function testBase(): void
    {
        $botCommand = new RichTextBotCommand('hello', '/start');

        assertSame('bot_command', $botCommand->getType());
        assertSame('hello', $botCommand->text);
        assertSame('/start', $botCommand->botCommand);
    }

    public function testFromTelegramResult(): void
    {
        $botCommand = (new ObjectFactory())->create([
            'type' => 'bot_command',
            'text' => 'hello',
            'bot_command' => '/start',
        ], null, RichTextBotCommand::class);

        assertSame('bot_command', $botCommand->getType());
        assertSame('hello', $botCommand->text);
        assertSame('/start', $botCommand->botCommand);
    }
}
