<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\CopyTextButton;
use Phptg\BotApi\Type\DisabledButton;
use Phptg\BotApi\Type\LoginUrl;
use Phptg\BotApi\Type\RichMessageButton;
use Phptg\BotApi\Type\RichTextBold;
use Phptg\BotApi\Type\SwitchInlineQueryChosenChat;
use Phptg\BotApi\Type\WebAppInfo;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class RichMessageButtonTest extends TestCase
{
    public function testBase(): void
    {
        $button = new RichMessageButton('test');

        assertSame('test', $button->text);
        assertNull($button->style);
        assertNull($button->url);
        assertNull($button->callbackData);
        assertNull($button->webApp);
        assertNull($button->loginUrl);
        assertNull($button->switchInlineQuery);
        assertNull($button->switchInlineQueryCurrentChat);
        assertNull($button->switchInlineQueryChosenChat);
        assertNull($button->copyText);
        assertNull($button->disabled);

        assertSame(
            [
                'text' => 'test',
            ],
            $button->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $webApp = new WebAppInfo('https://example.com/test');
        $loginUrl = new LoginUrl('https://example.com/login');
        $switchInlineQueryChosenChat = new SwitchInlineQueryChosenChat('dg');
        $copyText = new CopyTextButton('Copy it!');
        $disabled = new DisabledButton();
        $text = new RichTextBold('test');
        $button = new RichMessageButton(
            $text,
            'danger',
            'https://example.com',
            'callback-data',
            $webApp,
            $loginUrl,
            'switch-inline-query',
            'switch-inline-query-current-chat',
            $switchInlineQueryChosenChat,
            $copyText,
            $disabled,
        );

        assertSame($text, $button->text);
        assertSame('danger', $button->style);
        assertSame('https://example.com', $button->url);
        assertSame('callback-data', $button->callbackData);
        assertSame($webApp, $button->webApp);
        assertSame($loginUrl, $button->loginUrl);
        assertSame('switch-inline-query', $button->switchInlineQuery);
        assertSame('switch-inline-query-current-chat', $button->switchInlineQueryCurrentChat);
        assertSame($switchInlineQueryChosenChat, $button->switchInlineQueryChosenChat);
        assertSame($copyText, $button->copyText);
        assertSame($disabled, $button->disabled);

        assertSame(
            [
                'text' => $text->toRequestArray(),
                'style' => 'danger',
                'url' => 'https://example.com',
                'callback_data' => 'callback-data',
                'web_app' => $webApp->toRequestArray(),
                'login_url' => $loginUrl->toRequestArray(),
                'switch_inline_query' => 'switch-inline-query',
                'switch_inline_query_current_chat' => 'switch-inline-query-current-chat',
                'switch_inline_query_chosen_chat' => $switchInlineQueryChosenChat->toRequestArray(),
                'copy_text' => $copyText->toRequestArray(),
                'disabled' => [],
            ],
            $button->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'text' => 'test',
        ], null, RichMessageButton::class);

        assertSame('test', $button->text);
        assertNull($button->style);
        assertNull($button->url);
        assertNull($button->callbackData);
        assertNull($button->webApp);
        assertNull($button->loginUrl);
        assertNull($button->switchInlineQuery);
        assertNull($button->switchInlineQueryCurrentChat);
        assertNull($button->switchInlineQueryChosenChat);
        assertNull($button->copyText);
        assertNull($button->disabled);
    }

    public function testFromTelegramResultFull(): void
    {
        $button = (new ObjectFactory())->create([
            'text' => [
                'type' => 'bold',
                'text' => 'test',
            ],
            'style' => 'danger',
            'url' => 'https://example.com',
            'callback_data' => 'callback-data',
            'web_app' => ['url' => 'https://example.com/test'],
            'login_url' => ['url' => 'https://example.com/login'],
            'switch_inline_query' => 'switch-inline-query',
            'switch_inline_query_current_chat' => 'switch-inline-query-current-chat',
            'switch_inline_query_chosen_chat' => ['query' => 'dg'],
            'copy_text' => ['text' => 'Copy it!'],
            'disabled' => [],
        ], null, RichMessageButton::class);

        assertInstanceOf(RichTextBold::class, $button->text);
        assertSame('test', $button->text->text);
        assertSame('danger', $button->style);
        assertSame('https://example.com', $button->url);
        assertSame('callback-data', $button->callbackData);
        assertInstanceOf(WebAppInfo::class, $button->webApp);
        assertSame('https://example.com/test', $button->webApp->url);
        assertInstanceOf(LoginUrl::class, $button->loginUrl);
        assertSame('https://example.com/login', $button->loginUrl->url);
        assertSame('switch-inline-query', $button->switchInlineQuery);
        assertSame('switch-inline-query-current-chat', $button->switchInlineQueryCurrentChat);
        assertInstanceOf(SwitchInlineQueryChosenChat::class, $button->switchInlineQueryChosenChat);
        assertSame('dg', $button->switchInlineQueryChosenChat->query);
        assertInstanceOf(CopyTextButton::class, $button->copyText);
        assertSame('Copy it!', $button->copyText->text);
        assertInstanceOf(DisabledButton::class, $button->disabled);
    }
}
