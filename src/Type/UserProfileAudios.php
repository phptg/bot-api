<?php

declare(strict_types=1);

namespace Phptg\BotApi\Type;

use Phptg\BotApi\ParseResult\ValueProcessor\ArrayOfObjectsValue;

/**
 * @see https://core.telegram.org/bots/api#userprofileaudios
 *
 * @api
 */
final readonly class UserProfileAudios
{
    /**
     * @param Audio[] $audios
     */
    public function __construct(
        public int $totalCount,
        #[ArrayOfObjectsValue(Audio::class)]
        public array $audios,
    ) {}
}
