<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestchat
 *
 * @api
 */
final readonly class KeyboardButtonRequestChat
{
    public function __construct(
        public int $requestId,
        public bool $chatIsChannel,
        public ?bool $chatIsForum = null,
        public ?bool $chatHasUsername = null,
        public ?bool $chatIsCreated = null,
        public ?ChatAdministratorRights $userAdministratorRights = null,
        public ?ChatAdministratorRights $botAdministratorRights = null,
        public ?bool $botIsMember = null,
        public ?bool $requestTitle = null,
        public ?bool $requestUsername = null,
        public ?bool $requestPhoto = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->requestId,
                'chat_is_channel' => $this->chatIsChannel,
                'chat_is_forum' => $this->chatIsForum,
                'chat_has_username' => $this->chatHasUsername,
                'chat_is_created' => $this->chatIsCreated,
                'user_administrator_rights' => $this->userAdministratorRights?->toRequestArray(),
                'bot_administrator_rights' => $this->botAdministratorRights?->toRequestArray(),
                'bot_is_member' => $this->botIsMember,
                'request_title' => $this->requestTitle,
                'request_username' => $this->requestUsername,
                'request_photo' => $this->requestPhoto,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
