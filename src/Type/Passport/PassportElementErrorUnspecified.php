<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrorunspecified
 *
 * @api
 */
final readonly class PassportElementErrorUnspecified implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $elementHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'unspecified';
    }

    public function toRequestArray(): array
    {
        return [
            'source' => $this->getSource(),
            'type' => $this->type,
            'element_hash' => $this->elementHash,
            'message' => $this->message,
        ];
    }
}
