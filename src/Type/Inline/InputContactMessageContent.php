<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Inline;

/**
 * @see https://core.telegram.org/bots/api#inputcontactmessagecontent
 *
 * @api
 */
final readonly class InputContactMessageContent implements InputMessageContent
{
    public function __construct(
        public string $phoneNumber,
        public string $firstName,
        public ?string $lastName = null,
        public ?string $vcard = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'phone_number' => $this->phoneNumber,
                'first_name' => $this->firstName,
                'last_name' => $this->lastName,
                'vcard' => $this->vcard,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
