<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#ownedgiftunique
 *
 * @api
 */
final readonly class OwnedGiftUnique implements OwnedGift
{
    public function __construct(
        public UniqueGift $gift,
        public DateTimeImmutable $sendDate,
        public ?string $ownedGiftId = null,
        public ?User $senderUser = null,
        public ?true $isSaved = null,
        public ?true $canBeTransferred = null,
        public ?int $transferStarCount = null,
        public ?DateTimeImmutable $nextTransferDate = null,
    ) {}

    public function getType(): string
    {
        return 'unique';
    }
}
