<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrorreverseside
 *
 * @api
 */
final readonly class PassportElementErrorReverseSide implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $fileHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'reverse_side';
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
