<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopechatadministrators
 *
 * @api
 */
final readonly class BotCommandScopeChatAdministrators implements BotCommandScope
{
    public function __construct(
        public int|string $chatId,
    ) {}

    public function getType(): string
    {
        return 'chat_administrators';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'chat_id' => $this->chatId,
        ];
    }
}
