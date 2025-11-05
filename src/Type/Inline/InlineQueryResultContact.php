<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

use Phptg\BotApi\Type\InlineKeyboardMarkup;

/**
 * @see https://core.telegram.org/bots/api#inlinequeryresultcontact
 *
 * @api
 */
final readonly class InlineQueryResultContact implements InlineQueryResult
{
    public function __construct(
        public string $id,
        public string $phoneNumber,
        public string $firstName,
        public ?string $lastName = null,
        public ?string $vcard = null,
        public ?InlineKeyboardMarkup $replyMarkup = null,
        public ?InputMessageContent $inputMessageContent = null,
        public ?string $thumbnailUrl = null,
        public ?int $thumbnailWidth = null,
        public ?int $thumbnailHeight = null,
    ) {}

    public function getType(): string
    {
        return 'contact';
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->getType(),
                'id' => $this->id,
                'phone_number' => $this->phoneNumber,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'vcard' => $this->vcard,
                'reply_markup' => $this->replyMarkup?->toRequestArray(),
                'input_message_content' => $this->inputMessageContent?->toRequestArray(),
                'thumbnail_url' => $this->thumbnailUrl,
                'thumbnail_width' => $this->thumbnailWidth,
                'thumbnail_height' => $this->thumbnailHeight,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
