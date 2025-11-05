<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#menubuttoncommands
 *
 * @api
 */
final readonly class MenuButtonCommands implements MenuButton
{
    public function getType(): string
    {
        return 'commands';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
