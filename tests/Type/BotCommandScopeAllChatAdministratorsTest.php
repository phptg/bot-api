<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Type\BotCommandScopeAllChatAdministrators;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeAllChatAdministratorsTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeAllChatAdministrators();

        assertSame('all_chat_administrators', $scope->getType());

        assertSame(
            [
                'type' => 'all_chat_administrators',
            ],
            $scope->toRequestArray(),
        );
    }
}
