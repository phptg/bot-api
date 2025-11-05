<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#shareduser
 *
 * @api
 */
final readonly class SharedUser
{
    /**
     * @param PhotoSize[]|null $photo
     */
    public function __construct(
        public int $userId,
        public ?string $firstName = null,
        public ?string $lastName = null,
        public ?string $username = null,
        #[ArrayOfObjectsValue(PhotoSize::class)]
        public ?array $photo = null,
    ) {}
}
