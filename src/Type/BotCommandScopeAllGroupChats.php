<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopeallgroupchats
 *
 * @api
 */
final readonly class BotCommandScopeAllGroupChats implements BotCommandScope
{
    public function getType(): string
    {
        return 'all_group_chats';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
