<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\Constant\MessageEntityType;

/**
 * @see https://core.telegram.org/bots/api#messageentity
 *
 * @api
 */
final readonly class MessageEntity
{
    /**
     * @param string $type Type of the entity ({@see MessageEntityType}).
     */
    public function __construct(
        public string $type,
        public int $offset,
        public int $length,
        public ?string $url = null,
        public ?User $user = null,
        public ?string $language = null,
        public ?string $customEmojiId = null,
        public ?int $unixTime = null,
        public ?string $dateTimeFormat = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->type,
                'offset' => $this->offset,
                'length' => $this->length,
                'url' => $this->url,
                'user' => $this->user?->toRequestArray(),
                'language' => $this->language,
                'custom_emoji_id' => $this->customEmojiId,
                'unix_time' => $this->unixTime,
                'date_time_format' => $this->dateTimeFormat,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
