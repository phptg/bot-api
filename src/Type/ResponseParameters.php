<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#responseparameters
 *
 * @api
 */
final readonly class ResponseParameters
{
    public function __construct(
        public ?int $migrateToChatId = null,
        public ?int $retryAfter = null,
    ) {}

    public static function fromDecodedBody(array $body): ?self
    {
        if (!isset($body['parameters']) || !is_array($body['parameters'])) {
            return null;
        }

        $raw = $body['parameters'];
        $migrateToChatId = $raw['migrate_to_chat_id'] ?? null;
        $retryAfter = $raw['retry_after'] ?? null;

        return new self(
            is_int($migrateToChatId) ? $migrateToChatId : null,
            is_int($retryAfter) ? $retryAfter : null,
        );
    }
}
