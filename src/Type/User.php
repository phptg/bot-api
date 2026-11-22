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
    ) {}

    /**
     * @return array<string, mixed>
     */
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
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
