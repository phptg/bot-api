<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#keyboardbuttonrequestmanagedbot
 *
 * @api
 */
final readonly class KeyboardButtonRequestManagedBot
{
    public function __construct(
        public int $requestId,
        public ?string $suggestedName = null,
        public ?string $suggestedUsername = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'request_id' => $this->requestId,
                'suggested_name' => $this->suggestedName,
                'suggested_username' => $this->suggestedUsername,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
