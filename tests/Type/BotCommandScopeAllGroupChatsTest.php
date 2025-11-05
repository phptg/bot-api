<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\BotCommandScopeAllGroupChats;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeAllGroupChatsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeAllGroupChats();

        assertSame('all_group_chats', $scope->getType());

        assertSame(
            [
                'type' => 'all_group_chats',
            ],
            $scope->toRequestArray(),
        );
    }
}
