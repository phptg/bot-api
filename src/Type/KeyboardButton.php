<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#keyboardbutton
 *
 * @api
 */
final readonly class KeyboardButton
{
    public function __construct(
        public string $text,
        public ?KeyboardButtonRequestUsers $requestUsers = null,
        public ?KeyboardButtonRequestChat $requestChat = null,
        public ?bool $requestContact = null,
        public ?bool $requestLocation = null,
        public ?KeyboardButtonPollType $requestPoll = null,
        public ?WebAppInfo $webApp = null,
        public ?string $iconCustomEmojiId = null,
        public ?string $style = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'text' => $this->text,
                'icon_custom_emoji_id' => $this->iconCustomEmojiId,
                'style' => $this->style,
                'request_users' => $this->requestUsers?->toRequestArray(),
                'request_chat' => $this->requestChat?->toRequestArray(),
                'request_contact' => $this->requestContact,
                'request_location' => $this->requestLocation,
                'request_poll' => $this->requestPoll?->toRequestArray(),
                'web_app' => $this->webApp?->toRequestArray(),
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
