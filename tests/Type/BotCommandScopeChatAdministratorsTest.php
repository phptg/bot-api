<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\BotCommandScopeChatAdministrators;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeChatAdministratorsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeChatAdministrators(1);

        assertSame('chat_administrators', $scope->getType());
        assertSame(1, $scope->chatId);

        assertSame(
            [
                'type' => 'chat_administrators',
                'chat_id' => 1,
            ],
            $scope->toRequestArray(),
        );
    }
}
