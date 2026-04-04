<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#polloption
 *
 * @api
 */
final readonly class PollOption
{
    /**
     * @param MessageEntity[]|null $textEntities
     */
    public function __construct(
        public string $persistentId,
        public string $text,
        public int $voterCount,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $textEntities = null,
        public ?User $addedByUser = null,
        public ?Chat $addedByChat = null,
        public ?int $additionDate = null,
    ) {}
}
