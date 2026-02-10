<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\CopyTextButton;
use Phptg\BotApi\Type\Game\CallbackGame;
use Phptg\BotApi\Type\InlineKeyboardButton;
use Phptg\BotApi\Type\LoginUrl;
use Phptg\BotApi\Type\SwitchInlineQueryChosenChat;
use Phptg\BotApi\Type\WebAppInfo;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InlineKeyboardButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new InlineKeyboardButton('test');

        assertSame('test', $button->text);
        assertNull($button->iconCustomEmojiId);
        assertNull($button->style);
        assertNull($button->url);
        assertNull($button->callbackData);
        assertNull($button->webApp);
        assertNull($button->loginUrl);
        assertNull($button->switchInlineQuery);
        assertNull($button->switchInlineQueryCurrentChat);
        assertNull($button->switchInlineQueryChosenChat);
        assertNull($button->copyText);
        assertNull($button->callbackGame);
        assertNull($button->pay);

        assertSame(
            [
                'text' => 'test',
            ],
            $button->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $webApp = new WebAppInfo('https://example.com/test');
        $loginUrl = new LoginUrl('https://example.com/login');
        $switchInlineQueryChosenChat  = new SwitchInlineQueryChosenChat('dg');
        $callbackGame = new CallbackGame();
        $copyText = new CopyTextButton('Copy it!');
        $button = new InlineKeyboardButton(
            'test',
            'https://example.com',
            'callback-data',
            $webApp,
            $loginUrl,
            'switch-inline-query',
            'switch-inline-query-current-chat',
            $switchInlineQueryChosenChat,
            $callbackGame,
            true,
            $copyText,
            '5368324170671202286',
            'primary',
        );

        assertSame('test', $button->text);
        assertSame('5368324170671202286', $button->iconCustomEmojiId);
        assertSame('primary', $button->style);
        assertSame('https://example.com', $button->url);
        assertSame('callback-data', $button->callbackData);
        assertSame($webApp, $button->webApp);
        assertSame($loginUrl, $button->loginUrl);
        assertSame('switch-inline-query', $button->switchInlineQuery);
        assertSame('switch-inline-query-current-chat', $button->switchInlineQueryCurrentChat);
        assertSame($switchInlineQueryChosenChat, $button->switchInlineQueryChosenChat);
        assertSame($copyText, $button->copyText);
        assertSame($callbackGame, $button->callbackGame);
        assertTrue($button->pay);

        assertSame(
            [
                'text' => 'test',
                'icon_custom_emoji_id' => '5368324170671202286',
                'style' => 'primary',
                'url' => 'https://example.com',
                'callback_data' => 'callback-data',
                'web_app' => $webApp->toRequestArray(),
                'login_url' => $loginUrl->toRequestArray(),
                'switch_inline_query' => 'switch-inline-query',
                'switch_inline_query_current_chat' => 'switch-inline-query-current-chat',
                'switch_inline_query_chosen_chat' => $switchInlineQueryChosenChat->toRequestArray(),
                'copy_text' => $copyText->toRequestArray(),
                'callback_game' => $callbackGame->toRequestArray(),
                'pay' => true,
            ],
            $button->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'text' => 'test',
            'icon_custom_emoji_id' => '5368324170671202286',
            'style' => 'primary',
            'url' => 'https://example.com',
            'callback_data' => 'callback-data',
            'web_app' => ['url' => 'https://example.com/test'],
            'login_url' => ['url' => 'https://example.com/login'],
            'switch_inline_query' => 'switch-inline-query',
            'switch_inline_query_current_chat' => 'switch-inline-query-current-chat',
            'switch_inline_query_chosen_chat' => ['query' => 'dg'],
            'copy_text' => ['text' => 'Copy it!'],
            'callback_game' => [],
            'pay' => true,
        ], null, InlineKeyboardButton::class);

        assertSame('test', $button->text);
        assertSame('5368324170671202286', $button->iconCustomEmojiId);
        assertSame('primary', $button->style);
        assertSame('https://example.com', $button->url);
        assertSame('callback-data', $button->callbackData);
        assertSame('https://example.com/test', $button->webApp?->url);
        assertSame('https://example.com/login', $button->loginUrl?->url);
        assertSame('switch-inline-query', $button->switchInlineQuery);
        assertSame('switch-inline-query-current-chat', $button->switchInlineQueryCurrentChat);
        assertSame('dg', $button->switchInlineQueryChosenChat->query);
        assertSame('Copy it!', $button->copyText->text);
        assertInstanceOf(CallbackGame::class, $button->callbackGame);
        assertTrue($button->pay);
    }
}
