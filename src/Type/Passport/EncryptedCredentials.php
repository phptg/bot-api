<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

/**
 * @see https://core.telegram.org/bots/api#encryptedcredentials
 *
 * @api
 */
final readonly class EncryptedCredentials
{
    public function __construct(
        public string $data,
        public string $hash,
        public string $secret,
    ) {}
}
