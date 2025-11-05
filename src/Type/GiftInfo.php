<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\Type\Sticker\Gift;

/**
 * @see https://core.telegram.org/bots/api#giftinfo
 *
 * @api
 */
final readonly class GiftInfo
{
    /**
     * @param MessageEntity[]|null $entities
     */
    public function __construct(
        public Gift $gift,
        public ?string $ownedGiftId = null,
        public ?int $convertStarCount = null,
        public ?int $prepaidUpgradeStarCount = null,
        public ?true $canBeUpgraded = null,
        public ?string $text = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $entities = null,
        public ?true $isPrivate = null,
    ) {}
}
