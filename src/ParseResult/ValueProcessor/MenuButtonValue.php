<?php

declare(strict_types=1);

namespace Phptg\BotApi\ParseResult\ValueProcessor;

use Phptg\BotApi\Type\MenuButton;
use Phptg\BotApi\Type\MenuButtonCommands;
use Phptg\BotApi\Type\MenuButtonDefault;
use Phptg\BotApi\Type\MenuButtonWebApp;

/**
 * @template-extends InterfaceValue<MenuButton>
 */
final readonly class MenuButtonValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'commands' => MenuButtonCommands::class,
            'web_app' => MenuButtonWebApp::class,
            'default' => MenuButtonDefault::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown menu button type.';
    }
}
