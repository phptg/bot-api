<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;
use Phptg\BotApi\ParseResult\ValueProcessor\MaybeInaccessibleMessageValue;

/**
 * @see https://core.telegram.org/bots/api#polloptiondeleted
 *
 * @api
 */
final readonly class PollOptionDeleted
{
    /**
     * @param MessageEntity[]|null $optionTextEntities
     */
    public function __construct(
        public string $optionPersistentId,
        public string $optionText,
        #[MaybeInaccessibleMessageValue]
        public Message|InaccessibleMessage|null $pollMessage = null,
        #[ArrayOfObjectsValue(MessageEntity::class)]
        public ?array $optionTextEntities = null,
    ) {}
}
