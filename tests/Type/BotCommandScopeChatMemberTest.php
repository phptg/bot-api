<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\BotCommandScopeChatMember;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeChatMemberTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeChatMember(1, 2);

        assertSame('chat_member', $scope->getType());
        assertSame(1, $scope->chatId);
        assertSame(2, $scope->userId);

        assertSame(
            [
                'type' => 'chat_member',
                'chat_id' => 1,
                'user_id' => 2,
            ],
            $scope->toRequestArray(),
        );
    }
}
