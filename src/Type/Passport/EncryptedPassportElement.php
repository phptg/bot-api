<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#encryptedpassportelement
 *
 * @api
 */
final readonly class EncryptedPassportElement
{
    /**
     * @param PassportFile[]|null $files
     * @param PassportFile[]|null $translation
     */
    public function __construct(
        public string $type,
        public string $hash,
        public ?string $data = null,
        public ?string $phoneNumber = null,
        public ?string $email = null,
        #[ArrayOfObjectsValue(PassportFile::class)]
        public ?array $files = null,
        public ?PassportFile $frontSide = null,
        public ?PassportFile $reverseSide = null,
        public ?PassportFile $selfie = null,
        #[ArrayOfObjectsValue(PassportFile::class)]
        public ?array $translation = null,
    ) {}
}
