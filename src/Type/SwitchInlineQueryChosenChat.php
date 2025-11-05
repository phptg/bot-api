<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 *
 * @api
 */
final readonly class SwitchInlineQueryChosenChat
{
    public function __construct(
        public ?string $query = null,
        public ?bool $allowUserChats = null,
        public ?bool $allowBotChats = null,
        public ?bool $allowGroupChats = null,
        public ?bool $allowChannelChats = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'query' => $this->query,
                'allow_user_chats' => $this->allowUserChats,
                'allow_bot_chats' => $this->allowBotChats,
                'allow_group_chats' => $this->allowGroupChats,
                'allow_channel_chats' => $this->allowChannelChats,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
