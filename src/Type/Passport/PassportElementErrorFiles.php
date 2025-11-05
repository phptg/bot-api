<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#passportelementerrorfiles
 *
 * @api
 */
final readonly class PassportElementErrorFiles implements PassportElementError
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
        return 'files';
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
