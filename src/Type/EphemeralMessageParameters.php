<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#ephemeralmessageparameters
 *
 * @api
 */
final readonly class EphemeralMessageParameters
{
    public function __construct(
        public int $receiverUserId,
        public ?string $callbackQueryId = null,
        public ?bool $replaceCallbackQueryMessage = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toRequestArray(): array
    {
        return array_filter(
            [
                'receiver_user_id' => $this->receiverUserId,
                'callback_query_id' => $this->callbackQueryId,
                'replace_callback_query_message' => $this->replaceCallbackQueryMessage,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
