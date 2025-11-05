<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#loginurl
 *
 * @api
 */
final readonly class LoginUrl
{
    public function __construct(
        public string $url,
        public ?string $forwardText = null,
        public ?string $botUsername = null,
        public ?bool $requestWriteAccess = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'url' => $this->url,
                'forward_text' => $this->forwardText,
                'bot_username' => $this->botUsername,
                'request_write_access' => $this->requestWriteAccess,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
