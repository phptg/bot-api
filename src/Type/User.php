<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#user
 *
 * @api
 */
final readonly class User
{
    public function __construct(
        public int $id,
        public bool $isBot,
        public string $firstName,
        public ?string $lastName = null,
        public ?string $username = null,
        public ?string $languageCode = null,
        public ?true $isPremium = null,
        public ?true $addedToAttachmentMenu = null,
        public ?bool $canJoinGroups = null,
        public ?bool $canReadAllGroupMessages = null,
        public ?bool $supportsInlineQueries = null,
        public ?bool $canConnectToBusiness = null,
        public ?bool $hasMainWebApp = null,
        public ?bool $hasTopicsEnabled = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'id' => $this->id,
                'is_bot' => $this->isBot,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'username' => $this->username,
                'language_code' => $this->languageCode,
                'is_premium' => $this->isPremium,
                'added_to_attachment_menu' => $this->addedToAttachmentMenu,
                'can_join_groups' => $this->canJoinGroups,
                'can_read_all_group_messages' => $this->canReadAllGroupMessages,
                'supports_inline_queries' => $this->supportsInlineQueries,
                'can_connect_to_business' => $this->canConnectToBusiness,
                'has_main_web_app' => $this->hasMainWebApp,
                'has_topics_enabled' => $this->hasTopicsEnabled,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
