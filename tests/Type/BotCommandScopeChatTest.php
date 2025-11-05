<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\BotCommandScopeChat;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeChatTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeChat(1);

        assertSame('chat', $scope->getType());
        assertSame(1, $scope->chatId);

        assertSame(
            [
                'type' => 'chat',
                'chat_id' => 1,
            ],
            $scope->toRequestArray(),
        );
    }
}
