<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrortranslationfiles
 *
 * @api
 */
final readonly class PassportElementErrorTranslationFiles implements PassportElementError
{
    /**
     * @param string[] $fileHashes
     */
    public function __construct(
        public string $type,
        public array $fileHashes,
        public string $message,
    ) {}

    public function getSource(): string
    {
        return 'translation_files';
    }

    public function toRequestArray(): array
    {
        return [
            'source' => $this->getSource(),
            'type' => $this->type,
            'file_hashes' => $this->fileHashes,
            'message' => $this->message,
        ];
    }
}
