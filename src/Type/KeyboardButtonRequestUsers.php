<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestusers
 *
 * @api
 */
final readonly class KeyboardButtonRequestUsers
{
    public function __construct(
        public int $requestId,
        public ?bool $userIsBot = null,
        public ?bool $userIsPremium = null,
        public ?int $maxQuantity = null,
        public ?bool $requestName = null,
        public ?bool $requestUsername = null,
        public ?bool $requestPhoto = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->requestId,
                'user_is_bot' => $this->userIsBot,
                'user_is_premium' => $this->userIsPremium,
                'max_quantity' => $this->maxQuantity,
                'request_name' => $this->requestName,
                'request_username' => $this->requestUsername,
                'request_photo' => $this->requestPhoto,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
