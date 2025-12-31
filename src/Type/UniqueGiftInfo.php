<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftinfo
 *
 * @api
 */
final readonly class UniqueGiftInfo
{
    public function __construct(
        public UniqueGift $gift,
        public string $origin,
        public ?string $ownedGiftId = null,
        public ?int $transferStarCount = null,
        public ?string $lastResaleCurrency = null,
        public ?int $lastResaleAmount = null,
        public ?DateTimeImmutable $nextTransferDate = null,
    ) {}
}
