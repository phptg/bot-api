<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\SwitchInlineQueryChosenChat;

use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SwitchInlineQueryChosenChatTest extends TestCase
{
    public function testBase(): void
    {
        $switchInlineQueryChosenChat = new SwitchInlineQueryChosenChat();

        assertNull($switchInlineQueryChosenChat->query);
        assertNull($switchInlineQueryChosenChat->allowUserChats);
        assertNull($switchInlineQueryChosenChat->allowBotChats);
        assertNull($switchInlineQueryChosenChat->allowGroupChats);
        assertNull($switchInlineQueryChosenChat->allowChannelChats);

        assertSame([], $switchInlineQueryChosenChat->toRequestArray());
    }

    public function testFilled(): void
    {
        $switchInlineQueryChosenChat = new SwitchInlineQueryChosenChat(
            'q1',
            true,
            true,
            false,
            false,
        );

        assertSame('q1', $switchInlineQueryChosenChat->query);
        assertTrue($switchInlineQueryChosenChat->allowUserChats);
        assertTrue($switchInlineQueryChosenChat->allowBotChats);
        assertFalse($switchInlineQueryChosenChat->allowGroupChats);
        assertFalse($switchInlineQueryChosenChat->allowChannelChats);

        assertSame(
            [
                'query' => 'q1',
                'allow_user_chats' => true,
                'allow_bot_chats' => true,
                'allow_group_chats' => false,
                'allow_channel_chats' => false,
            ],
            $switchInlineQueryChosenChat->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $switchInlineQueryChosenChat = (new ObjectFactory())->create([
            'query' => 'q1',
            'allow_user_chats' => true,
            'allow_bot_chats' => true,
            'allow_group_chats' => false,
            'allow_channel_chats' => false,
        ], null, SwitchInlineQueryChosenChat::class);

        assertSame('q1', $switchInlineQueryChosenChat->query);
        assertTrue($switchInlineQueryChosenChat->allowUserChats);
        assertTrue($switchInlineQueryChosenChat->allowBotChats);
        assertFalse($switchInlineQueryChosenChat->allowGroupChats);
        assertFalse($switchInlineQueryChosenChat->allowChannelChats);
    }
}
