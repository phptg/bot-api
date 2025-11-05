<?php

declare(strict_types=1);

namespace Phptg\BotApi\Tests\Method;

use PHPUnit\Framework\TestCase;
use Phptg\BotApi\Method\SetChatMenuButton;
use Phptg\BotApi\Transport\HttpMethod;
use Phptg\BotApi\Tests\Support\TestHelper;
use Phptg\BotApi\Type\MenuButtonDefault;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatMenuButtonTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetChatMenuButton();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatMenuButton', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $menuButton = new MenuButtonDefault();
        $method = new SetChatMenuButton(99, $menuButton);

        assertSame(
            [
                'chat_id' => 99,
                'menu_button' => $menuButton->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetChatMenuButton();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
