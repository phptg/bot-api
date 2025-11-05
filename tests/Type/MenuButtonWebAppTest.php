<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Type;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\ParseResult\ObjectFactory;
use Phptg\BotApi\Type\MenuButtonWebApp;
use Phptg\BotApi\Type\WebAppInfo;

use function PHPUnit\Framework\assertSame;

final class MenuButtonWebAppTest extends TestCase
{
    public function testBase(): void
    {
        $webApp = new WebAppInfo('https://example.com/');
        $button = new MenuButtonWebApp('test', $webApp);

        assertSame('web_app', $button->getType());
        assertSame('test', $button->text);
        assertSame($webApp, $button->webApp);

        assertSame([
            'type' => 'web_app',
            'text' => 'test',
            'web_app' => $webApp->toRequestArray(),
        ], $button->toRequestArray());
    }

    public function testFromTelegramResult(): void
    {
        $button = (new ObjectFactory())->create([
            'type' => 'web_app',
            'text' => 'test',
            'web_app' => [
                'url' => 'https://example.com',
            ],
        ], null, MenuButtonWebApp::class);

        assertSame('web_app', $button->getType());
        assertSame('test', $button->text);
        assertSame('https://example.com', $button->webApp->url);
    }
}
