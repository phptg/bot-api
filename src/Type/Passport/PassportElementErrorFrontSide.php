<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrorfrontside
 *
 * @api
 */
final readonly class PassportElementErrorFrontSide implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $fileHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'front_side';
    }

    public function toRequestArray(): array
    {
        return [
            'source' => $this->getSource(),
            'type' => $this->type,
            'file_hash' => $this->fileHash,
            'message' => $this->message,
        ];
    }
}
