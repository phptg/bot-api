<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\BotCommand;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class BotCommandTest extends TestCase
{
    public function testBase(): void
    {
        $botCommand = new BotCommand('start', 'Start command');

        assertSame('start', $botCommand->command);
        assertSame('Start command', $botCommand->description);
        assertNull($botCommand->isEphemeral);

        assertSame(
            [
                'command' => 'start',
                'description' => 'Start command',
            ],
            $botCommand->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $botCommand = new BotCommand('start', 'Start command', true);

        assertTrue($botCommand->isEphemeral);
        assertSame(
            [
                'command' => 'start',
                'description' => 'Start command',
                'is_ephemeral' => true,
            ],
            $botCommand->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $botCommand = (new ObjectFactory())->create([
            'command' => 'start',
            'description' => 'Start command',
        ], null, BotCommand::class);

        assertSame('start', $botCommand->command);
        assertSame('Start command', $botCommand->description);
        assertNull($botCommand->isEphemeral);
    }

    public function testFromTelegramResultFull(): void
    {
        $botCommand = (new ObjectFactory())->create([
            'command' => 'start',
            'description' => 'Start command',
            'is_ephemeral' => true,
        ], null, BotCommand::class);

        assertTrue($botCommand->isEphemeral);
    }
}
