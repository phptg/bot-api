<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopedefault
 *
 * @api
 */
final readonly class BotCommandScopeDefault implements BotCommandScope
{
    public function getType(): string
    {
        return 'default';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
