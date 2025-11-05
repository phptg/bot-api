<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrortranslationfile
 *
 * @api
 */
final readonly class PassportElementErrorTranslationFile implements PassportElementError
{
    public function __construct(
        public string $type,
        public string $fileHash,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'translation_file';
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
