<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrordatafield
 *
 * @api
 */
final readonly class PassportElementErrorDataField implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $fieldName,
        public string $dataHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'data';
    }

    public function toRequestArray(): array
    {
        return [
            'source' => $this->getSource(),
            'type' => $this->type,
            'field_name' => $this->fieldName,
            'data_hash' => $this->dataHash,
            'message' => $this->message,
        ];
    }
}
