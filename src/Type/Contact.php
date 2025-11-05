<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

/**
 * @see https://core.telegram.org/bots/api#contact
 *
 * @api
 */
final readonly class Contact
{
    public function __construct(
        public string $phoneNumber,
        public string $firstName,
        public ?string $lastName = null,
        public ?int $userId = null,
        public ?string $vcard = null,
    ) {}
}
