<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\Widget;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class WidgetTest extends TestCase
{
    public function testBase(): void
    {
        $widget = new Widget('<b>Hello!</b>');

        assertSame('<b>Hello!</b>', $widget->html);
        assertNull($widget->id);
        assertNull($widget->width);
        assertNull($widget->height);
        assertNull($widget->publicData);
        assertNull($widget->chatData);
    }

    public function testFull(): void
    {
        $widget = new Widget(
            '<b>Hello!</b>',
            'widget123',
            320,
            240,
            '{"key":"value"}',
            '{"chat":"data"}',
        );

        assertSame('<b>Hello!</b>', $widget->html);
        assertSame('widget123', $widget->id);
        assertSame(320, $widget->width);
        assertSame(240, $widget->height);
        assertSame('{"key":"value"}', $widget->publicData);
        assertSame('{"chat":"data"}', $widget->chatData);
    }

    public function testFromTelegramResult(): void
    {
        $widget = (new ObjectFactory())->create([
            'html' => '<b>Hello!</b>',
        ], null, Widget::class);

        assertSame('<b>Hello!</b>', $widget->html);
        assertNull($widget->id);
        assertNull($widget->width);
        assertNull($widget->height);
        assertNull($widget->publicData);
        assertNull($widget->chatData);
    }

    public function testFromTelegramResultFull(): void
    {
        $widget = (new ObjectFactory())->create([
            'id' => 'widget123',
            'width' => 320,
            'height' => 240,
            'html' => '<b>Hello!</b>',
            'public_data' => '{"key":"value"}',
            'chat_data' => '{"chat":"data"}',
        ], null, Widget::class);

        assertSame('<b>Hello!</b>', $widget->html);
        assertSame('widget123', $widget->id);
        assertSame(320, $widget->width);
        assertSame(240, $widget->height);
        assertSame('{"key":"value"}', $widget->publicData);
        assertSame('{"chat":"data"}', $widget->chatData);
    }
}
