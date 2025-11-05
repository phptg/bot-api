<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#chatshared
 *
 * @api
 */
final readonly class ChatShared
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public int $requestId,
        public int $chatId,
        public ?string $title = null,
        public ?string $username = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $photo = null,
    ) {}
}
