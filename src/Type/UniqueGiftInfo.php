<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use DateTimeImmutable;
use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#uniquegiftinfo
 *
 * @api
 */
final readonly class UniqueGiftInfo
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public UniqueGift $gift,
        public string $origin,
        public ?string $ownedGiftId = null,
        public ?int $transferStarCount = null,
        public ?string $lastResaleCurrency = null,
        public ?int $lastResaleAmount = null,
        public ?DateTimeImmutable $nextTransferDate = null,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isPrivate = null,
    ) {}
}
