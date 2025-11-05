<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type\Passport;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#passportfile
 *
 * @api
 */
final readonly class PassportFile
{
    public function __construct(
        public string $fileId,
        public string $fileUniqueId,
        public int $fileSize,
        public DateTimeImmutable $fileDate,
    ) {}
}
